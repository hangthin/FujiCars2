import * as THREE from "three";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";
import { OBJLoader } from "three/addons/loaders/OBJLoader.js";
import { OrbitControls } from "three/addons/controls/OrbitControls.js";
import { RGBELoader } from "three/addons/loaders/RGBELoader.js";
import { gsap } from "gsap";

const el = document.getElementById("khung-3d");
const nameEl = document.getElementById("ten-xe");
const descEl = document.getElementById("mo-ta-xe");
const nextBtn = document.getElementById("tiep-xe");

const cars = [
  { file: "models/car1.glb", name: "1975 Porsche 911 (930) Turbo", desc: "Mẫu xe thể thao huyền thoại" },
  { file: "models/car2.glb", name: "Ferrari F40", desc: "Biểu tượng tốc độ và hiệu năng" },
  { file: "models/car3.obj", name: "Ford F150 Raptor", desc: "Sức mạnh vượt mọi giới hạn" }
];

let current = 0;
let car, nextCar;

const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setSize(el.clientWidth, el.clientHeight);
renderer.outputColorSpace = THREE.SRGBColorSpace;
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
el.appendChild(renderer.domElement);

// ======= CẢNH & CAMERA =======
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(40, el.clientWidth / el.clientHeight, 0.1, 100);
camera.position.set(0, 1.2, 5.4);
scene.add(camera);

// ✅ NỀN GRADIENT (đen → đỏ sẫm)
{
  const bgCanvas = document.createElement("canvas");
  bgCanvas.width = bgCanvas.height = 32;
  const ctx = bgCanvas.getContext("2d");
  const gradient = ctx.createLinearGradient(0, 0, 0, 32);
  gradient.addColorStop(0, "#000000");
  gradient.addColorStop(1, "#2b0000");
  ctx.fillStyle = gradient;
  ctx.fillRect(0, 0, 32, 32);
  const bgTex = new THREE.CanvasTexture(bgCanvas);
  scene.background = bgTex;
}

// ======= ÁNH SÁNG SHOWROOM =======

// Ánh sáng môi trường dịu
scene.add(new THREE.HemisphereLight(0xffffff, 0x222222, 0.6));

// Đèn chiếu chính
const spotlight = new THREE.SpotLight(0xff3b3b, 3, 15, Math.PI / 6, 0.4, 1.5);
spotlight.position.set(2, 8, 4);
spotlight.castShadow = true;
scene.add(spotlight);

// Hiệu ứng đèn chiếu động (di chuyển nhẹ)
function animateLight() {
  gsap.to(spotlight.position, {
    x: Math.sin(Date.now() * 0.0003) * 5,
    y: 8 + Math.cos(Date.now() * 0.0005) * 1.5,
    z: Math.cos(Date.now() * 0.0004) * 5,
    duration: 2,
    repeat: -1,
    yoyo: true,
    ease: "sine.inOut"
  });
}
animateLight();

// Ánh sáng phụ tạo viền
const rimLight = new THREE.DirectionalLight(0xffffff, 0.5);
rimLight.position.set(-5, 3, -3);
scene.add(rimLight);

// ======= MÔI TRƯỜNG PHẢN CHIẾU =======
new RGBELoader().load(
  "https://dl.polyhaven.org/file/ph-assets/HDRIs/hdr/1k/studio_small_03_1k.hdr",
  tex => {
    tex.mapping = THREE.EquirectangularReflectionMapping;
    scene.environment = tex;
  }
);

// ======= SÀN CÓ PHẢN CHIẾU NHẸ =======
const floor = new THREE.Mesh(
  new THREE.CircleGeometry(6, 64),
  new THREE.MeshStandardMaterial({
    color: 0x111111,
    metalness: 0.3,
    roughness: 0.4,
    envMapIntensity: 0.8
  })
);
floor.rotation.x = -Math.PI / 2;
floor.receiveShadow = true;
scene.add(floor);

// ======= CONTROLS =======
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.enablePan = false;
controls.enableZoom = true;
controls.minDistance = 2.5;
controls.maxDistance = 25;
controls.zoomSpeed = 1.2;
controls.rotateSpeed = 0.6;
controls.target.set(0, 0.6, 0);
controls.update();

// ======= LOADERS =======
const gltfLoader = new GLTFLoader();
const objLoader = new OBJLoader();

function loadCar(index, isNext = false) {
  const carInfo = cars[index];
  const fileExt = carInfo.file.split(".").pop().toLowerCase();
  const loader = fileExt === "obj" ? objLoader : gltfLoader;

  loader.load(carInfo.file, result => {
    const obj = fileExt === "obj" ? result : result.scene;

    obj.traverse(o => {
      if (o.isMesh) {
        o.castShadow = true;
        o.receiveShadow = true;
      }
    });

    const box = new THREE.Box3().setFromObject(obj);
    const center = box.getCenter(new THREE.Vector3());
    obj.position.sub(center);
    obj.position.y = -box.min.y;
    obj.rotation.y = Math.PI;
    obj.position.x = isNext ? 8 : 0;
    scene.add(obj);

    if (isNext) {
      nextCar = obj;
      animateTransition();
    } else {
      car = obj;
      animate();
    }
  });
}

function animateTransition() {
  if (!car || !nextCar) return;
  gsap.to(car.position, { x: -8, duration: 1.2, ease: "power2.in" });
  gsap.to(nextCar.position, { x: 0, duration: 1.2, ease: "power2.out" });

  setTimeout(() => {
    scene.remove(car);
    car = nextCar;
    nextCar = null;
    nameEl.textContent = cars[current].name;
    descEl.textContent = cars[current].desc;
  }, 1200);
}

function nextCarAction() {
  current = (current + 1) % cars.length;
  loadCar(current, true);
}
nextBtn.addEventListener("click", nextCarAction);

function animate() {
  requestAnimationFrame(animate);
  if (car) car.rotation.y += 0.004;
  controls.update();
  renderer.render(scene, camera);
}

loadCar(current);

window.addEventListener("resize", () => {
  const w = el.clientWidth,
    h = el.clientHeight;
  camera.aspect = w / h;
  camera.updateProjectionMatrix();
  renderer.setSize(w, h);
});
