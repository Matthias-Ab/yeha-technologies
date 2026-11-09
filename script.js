const nav = document.getElementById('nav');
const links = document.getElementById('links');
const burger = document.getElementById('burger');

const onScroll = () => nav.classList.toggle('solid', window.scrollY > 60);
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

burger.addEventListener('click', () => {
  const open = links.classList.toggle('open');
  burger.setAttribute('aria-expanded', open);
});
links.querySelectorAll('a').forEach(a => a.addEventListener('click', () => links.classList.remove('open')));

const io = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
  });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => io.observe(el));

document.getElementById('yr').textContent = new Date().getFullYear();

// Static site: the form opens the visitor's email client. Replace the address below.
document.getElementById('form').addEventListener('submit', e => {
  e.preventDefault();
  const f = new FormData(e.target);
  const subject = encodeURIComponent(`Enquiry — Yeha ${f.get('division')}`);
  const body = encodeURIComponent(`Name: ${f.get('name')}\nEmail: ${f.get('email')}\n\n${f.get('message')}`);
  location.href = `mailto:info@yehatech.com?subject=${subject}&body=${body}`;
});
