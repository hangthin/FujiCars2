    // Mở/đóng ô tìm kiếm
    const fjxIconSearch = document.getElementById("fjx-search-icon");
    const fjxBoxSearch = document.getElementById("fjx-search-box");
    fjxIconSearch.addEventListener("click", (e) => {
      e.preventDefault();
      fjxBoxSearch.style.display = fjxBoxSearch.style.display === "flex" ? "none" : "flex";
    });

    // Mở/đóng popup ngôn ngữ
    const fjxOpenLang = document.getElementById("fjx-open-lang");
    const fjxCloseLang = document.getElementById("fjx-close-lang");
    const fjxPopupLang = document.getElementById("fjx-lang-popup");
    const fjxOverlay = document.getElementById("fjx-overlay");

    fjxOpenLang.addEventListener("click", () => {
      fjxPopupLang.style.display = "block";
      fjxOverlay.style.display = "block";
    });

    function fjxClosePopup() {
      fjxPopupLang.style.display = "none";
      fjxOverlay.style.display = "none";
    }

    fjxCloseLang.addEventListener("click", fjxClosePopup);
    fjxOverlay.addEventListener("click", fjxClosePopup);

    // Dịch ngôn ngữ
    const fjxLangs = {
      vi: { home: "Trang Chủ", product: "Sản Phẩm", register: "Đăng Ký", cart: "Giỏ Hàng", login: "Đăng nhập" },
      en: { home: "Home", product: "Cars", register: "Register", cart: "Cart", login: "Login" }
    };

    document.querySelectorAll(".fjx-lang-option").forEach(opt => {
      opt.addEventListener("click", () => {
        const lang = opt.dataset.lang;
        document.querySelectorAll("[data-key]").forEach(el => {
          const key = el.getAttribute("data-key");
          el.textContent = fjxLangs[lang][key];
        });
        fjxClosePopup();
      });
    });