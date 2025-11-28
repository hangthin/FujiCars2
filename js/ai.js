const chatAvatar = document.getElementById("chatAvatar");
const chatBoxContainer = document.getElementById("chatBoxContainer");
const chatInput = document.getElementById('chatInput');
const chatBox = document.getElementById('chatBox');
const sendChat = document.getElementById('sendChat');
const floatingMsg = document.getElementById('floatingMsg');

// Toggle chat
chatAvatar.addEventListener("click", () => {
  chatBoxContainer.style.display = (chatBoxContainer.style.display === "flex") ? "none" : "flex";
});

// Append message
function appendMessage(sender, text) {
  const msg = document.createElement('div');
  msg.classList.add('chat-ai-msg', sender);
  msg.innerHTML = text;
  chatBox.appendChild(msg);
  chatBox.scrollTop = chatBox.scrollHeight;
}

// ================== DỮ LIỆU SẢN PHẨM TỪ PHP (LOAD TỪ HTML) ==================
let products = window.productsData;

// ================== HÀM PHÂN TÍCH & TRẢ LỜI ==================
function getAIReply(question) {
  question = question.toLowerCase();

  // Phát hiện giá trị tiền
  const regex = /(\btrên\b|\bdưới\b|\btầm\b|\bkhoảng\b)?\s*(\d+([.,]?\d+)*)\s*(tỷ|tỉ|ty|ti|t|triệu|trieu|tr)?/i;
  const match = question.match(regex);
  let limitPrice = 0;
  let condition = "dưới";

  if(match){
    const keyword = (match[1]||"").trim().toLowerCase();
    const num = parseFloat(match[2].replace(',', '.'));
    const unit = (match[4]||'').toLowerCase();
    if(keyword.includes("trên")) condition = "trên";
    if(keyword.includes("dưới")) condition = "dưới";
    if(['tỷ','tỉ','ty','ti','t'].includes(unit)) limitPrice = num*1e9;
    else if(['triệu','trieu','tr'].includes(unit)) limitPrice = num*1e6;
  }

  // Trả lời theo giá
  if(limitPrice>0){
    let filtered=[], html="";
    if(condition==="trên"){
      filtered = products.filter(p=>parseFloat(p.Gia)>=limitPrice);
      if(filtered.length>0) html=`<i class="fa-solid fa-car"></i> Trên <b>${limitPrice.toLocaleString('vi-VN')}₫</b>, bạn có thể xem:<br><br>`;
      else return `Không có xe nào trên ${limitPrice.toLocaleString('vi-VN')}₫.`;
    }else{
      filtered = products.filter(p=>parseFloat(p.Gia)<=limitPrice);
      if(filtered.length>0) html=`<i class="fa-solid fa-car"></i> Dưới <b>${limitPrice.toLocaleString('vi-VN')}₫</b>, bạn có thể xem:<br><br>`;
      else return `Không có xe nào dưới ${limitPrice.toLocaleString('vi-VN')}₫.`;
    }
    filtered.forEach(p=>{
      html+=`
      <div style="border:1px solid #ccc;padding:8px;margin:6px;border-radius:8px;">
        <b>${p.TenSP}</b><br>
        <i class="fa-solid fa-money-bill-wave"></i> ${Number(p.Gia).toLocaleString('vi-VN')}₫<br>
        <i class="fa-solid fa-cube"></i> ${p.LoaiSP}<br>
        <i class="fa-solid fa-note-sticky"></i> ${p.MoTa}
      </div>
      `;
    });
    return html;
  }

  // Nếu hỏi xe cụ thể
  for(let p of products){
    if(question.includes(p.TenSP.toLowerCase())){
      return `
      <i class="fa-solid fa-car-side"></i> <b>${p.TenSP}</b><br>
      <i class="fa-solid fa-money-bill-wave"></i> Giá: ${Number(p.Gia).toLocaleString('vi-VN')}₫<br>
      <i class="fa-solid fa-cube"></i> Loại: ${p.LoaiSP}<br>
      <i class="fa-solid fa-note-sticky"></i> ${p.MoTa}
      `;
    }
  }

  // Câu hỏi phổ biến
  if(question.includes("giá")) return `<i class="fa-solid fa-money-bill-wave"></i> Bạn muốn hỏi giá của xe nào?`;
  if(question.includes("loại")||question.includes("dòng xe")){
    const loai=[...new Set(products.map(p=>p.LoaiSP))];
    return `<i class="fa-solid fa-car"></i> Các dòng xe hiện có: ${loai.join(", ")}`;
  }
  if(question.includes("tư vấn")||question.includes("phù hợp"))
    return `<i class="fa-solid fa-brain"></i> Hãy cho tôi biết nhu cầu của bạn để tôi gợi ý xe phù hợp.`;
  if(question.includes("chào")||question.includes("hello"))
    return `<i class="fa-regular fa-hand-wave"></i> Chào bạn! Tôi là <b>Fuji AI</b> – trợ lý tư vấn xe.`;

  return `<i class="fa-solid fa-robot"></i> Tôi chưa hiểu, hãy hỏi cụ thể hơn về tên xe, giá hoặc loại nhé!`;
}

// ================== SỰ KIỆN GỬI TIN NHẮN ==================
sendChat.addEventListener('click',()=>{
  const question = chatInput.value.trim();
  if(!question) return;
  appendMessage('user', question);
  chatInput.value="";
  setTimeout(()=>{
    const reply=getAIReply(question);
    appendMessage('bot', reply);
  },600);
});

chatInput.addEventListener('keypress',e=>{
  if(e.key==='Enter') sendChat.click();
});

// ================== Tin nhắn nổi ==================
window.addEventListener('load',()=>{
  floatingMsg.classList.add('show');
  setTimeout(()=>{floatingMsg.classList.remove('show');},5000);
});

floatingMsg.addEventListener('click',()=>{
  chatBoxContainer.style.display='flex';
  floatingMsg.style.display='none';
});
