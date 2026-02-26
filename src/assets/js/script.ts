import { common } from "./common/common";
import imgsrc from "/assets/images/js.png";

common();
console.log("script.ts loaded");

// --- Canvas処理 (エラー防止のガード付き) ---
const canvas = document.querySelector<HTMLCanvasElement>("#canvas");
if (canvas) {
  const context = canvas.getContext("2d");
  if (context) {
    const image = new Image(300, 300);
    image.src = imgsrc;
    image.onload = () => context.drawImage(image, 0, 0, 300, 300);
  }
}

// --- Ajax処理 (イベント委譲で確実に検知) ---
document.addEventListener('click', async (e) => {
  // クリックされた要素が #load-more-works かチェック
  const target = e.target as HTMLElement;
  if (!target || target.id !== 'load-more-works') return;

  e.preventDefault();
  const btn = target as HTMLButtonElement;
  const worksList = document.querySelector('#works-list');

  if (!worksList) {
    console.error("#works-list が見つかりません");
    return;
  }

  const page = parseInt(btn.dataset.page || "1");
  const ajaxUrl = '/wp-admin/admin-ajax.php';

  const formData = new URLSearchParams();
  formData.append('action', 'load_more_works');
  formData.append('page', page.toString());

  try {
    btn.innerText = 'Loading...';
    btn.disabled = true;

    const response = await fetch(ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: formData,
    });

    const data = await response.text();
    console.log("サーバーからの返事:", data);

    if (data && data.trim() !== "" && data !== "0") {
      worksList.insertAdjacentHTML('beforeend', data);
      btn.dataset.page = (page + 1).toString();
      btn.innerText = 'and more';
      btn.disabled = false;
    } else {
      console.log("データがないため終了します");
      btn.style.display = 'none';
    }
  } catch (error) {
    console.error('Fetch Error:', error);
    btn.innerText = 'Error!';
    btn.disabled = false;
  }
});

/* ======================================
    header用
====================================== */
const hamburger = document.getElementById('js-hamburger');
const nav = document.getElementById('js-nav');

if (hamburger && nav) {
  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('is-active');
    nav.classList.toggle('is-active');
    
    document.body.classList.toggle('u-overflow-hidden');
  });

  const navLinks = nav.querySelectorAll('a');
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      hamburger.classList.remove('is-active');
      nav.classList.remove('is-active');
      document.body.classList.remove('u-overflow-hidden');
    });
  });
}