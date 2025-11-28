let orders = window.jsonOrders || [];  // dùng biến global jsonOrders từ PHP
let filteredOrders = [...orders];
let selectedID = null;

const statusClassMap = {
    "Chờ xác nhận": "gxA1pending",
    "Đang láy thử": "gxA1doing",
    "Hoàn tất": "gxA1done",
    "Hủy": "gxA1cancel"
};

function renderOrders(){
    const box = document.getElementById("gxA1orderList");
    box.innerHTML = "";
    filteredOrders.forEach(o=>{
        box.innerHTML += `<div class="gxA1orderCard ${selectedID===o.id?"active":""}" onclick="selectOrder(${o.id})">
            <img src="${o.img}">
            <div>
                <b>${o.name}</b> – ${o.car}<br>
                <small>${o.date} ${o.time}</small><br>
                <span class="${statusClassMap[o.status] || ""}">${o.statusText}</span>
            </div>
        </div>`;
    });
}

function renderHours(){
    const hoursRow1 = ["07:00","08:00","09:00","10:00","11:00","12:00"];
    const hoursRow2 = ["13:00","14:00","15:00","16:00","17:00"];
    document.getElementById("gxA1hoursRow1").innerHTML = hoursRow1.map(h => `<div>${h}</div>`).join('');
    document.getElementById("gxA1hoursRow2").innerHTML = hoursRow2.map(h => `<div>${h}</div>`).join('');
}

function renderTimeline(){
    const row1 = document.getElementById("gxA1rowRow1");
    const row2 = document.getElementById("gxA1rowRow2");
    const hoursRow1 = ["07:00","08:00","09:00","10:00","11:00","12:00"];
    const hoursRow2 = ["13:00","14:00","15:00","16:00","17:00"];
    row1.innerHTML = hoursRow1.map(()=>`<div></div>`).join('');
    row2.innerHTML = hoursRow2.map(()=>`<div></div>`).join('');
    filteredOrders.forEach(o=>{
        let idx, block, row;
        if(hoursRow1.includes(o.time)){
            idx = hoursRow1.indexOf(o.time);
            row = row1;
        } else if(hoursRow2.includes(o.time)){
            idx = hoursRow2.indexOf(o.time);
            row = row2;
        } else return;
        block = document.createElement("div");
        block.className = `gxA1timelineOrder ${statusClassMap[o.status] || ""} ${selectedID===o.id?"gxA1selected":""}`;
        block.style.left = (idx * 120) + "px";
        block.innerHTML = `${o.time} – ${o.name}`;
        block.onclick = ()=> openDetail(o.id);
        row.appendChild(block);
    });
}

function selectOrder(id){ selectedID=id; renderOrders(); renderTimeline(); }

function openDetail(id){
    const o = filteredOrders.find(x=>x.id===id);
    selectedID = id;
    document.getElementById("gxA1modalContent").innerHTML = `<p><b>Khách:</b> ${o.name}</p>
        <p><b>Xe:</b> ${o.car}</p>
        <p><b>Ngày giờ:</b> ${o.date} ${o.time}</p>
        <p><b>Địa chỉ:</b> ${o.address}</p>
        <p><b>Trạng thái:</b> ${o.statusText}</p>`;
    document.getElementById("gxA1updateStatusSelect").value = o.status;
    document.getElementById("gxA1updateStatusID").value = id;
    document.getElementById("gxA1modal").style.display="flex";
}

function closeModal(){ document.getElementById("gxA1modal").style.display="none"; }

function applyFilters(){
    const type = document.getElementById("gxA1filterDateType").value;
    const date = document.getElementById("gxA1filterDate").value;
    const car = document.getElementById("gxA1filterCar").value.toLowerCase();
    filteredOrders = orders.filter(o=>{
        let passDate=true, passCar=true;
        if(date){
            const d = new Date(o.date);
            const input = new Date(date);
            if(type==="day") passDate=d.toDateString()===input.toDateString();
            else if(type==="week"){
                const getWeek=(d)=>Math.ceil(((d-new Date(d.getFullYear(),0,1))/86400000 + new Date(d.getFullYear(),0,1).getDay()+1)/7);
                passDate=getWeek(d)===getWeek(input);
            } else if(type==="month") passDate=d.getMonth()===input.getMonth() && d.getFullYear()===input.getFullYear();
            else if(type==="year") passDate=d.getFullYear()===input.getFullYear();
        }
        if(car) passCar=o.car.toLowerCase().includes(car);
        return passDate && passCar;
    });
    selectedID=null; renderOrders(); renderTimeline();
}

function resetFilters(){
    document.getElementById("gxA1filterDate").value="";
    document.getElementById("gxA1filterCar").value="";
    document.getElementById("gxA1filterDateType").value="all";
    filteredOrders=[...orders]; selectedID=null;
    renderOrders(); renderTimeline();
}

// Initialize
renderOrders(); 
renderHours(); 
renderTimeline();
