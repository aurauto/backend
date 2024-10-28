try {
  let showLink = document.querySelector('.show-link');
let checkboxBlock = document.querySelector('.checkbox-block');


showLink.addEventListener('click',function () {
	checkboxBlock.classList.toggle('.show-more');
}
);

} catch (error) {}