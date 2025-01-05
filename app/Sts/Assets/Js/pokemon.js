document.addEventListener('DOMContentLoaded', function () {


    progressBar();

});
function progressBar() {
    const stats = document.getElementsByClassName('stat-value');
    for (let i = 0; i < stats.length; i++) {
        let stat = stats[i];
        let statValue = stat.textContent;
        perValue = Math.min(Math.max(statValue / 2.55, 0), 250);
        let progressBar = stat.parentElement.parentElement.lastElementChild;
        progressBar.style.width = perValue + '%';

        //progressBar.style.backgroundColor = `rgb(2,0,36);`;
        //progressBar.style.background = `linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(0,92,134,1) ${perValue/4}%, rgba(0,212,255,1) ${perValue}%)`;
        let inverseValue = 100 - perValue;
        progressBar.style.background = `linear-gradient(90deg, rgba(2,8,56,1) 0%, rgba(0,174,255,1) ${inverseValue}%, rgba(0,231,255,1) 100%)`;

    }
}
let isClockwise = true;
function shinyChange() {
    let img = document.getElementById('pkm_img');
    let button = document.getElementById('swap_image');
    let imgDefoult = img.src;
    img.src = button.value;
    button.value = imgDefoult;

    if (isClockwise) {
        button.classList.remove('rotate-counterclockwise');
        button.classList.add('rotate-clockwise');
    } else {
        button.classList.remove('rotate-clockwise');
        button.classList.add('rotate-counterclockwise');
    }
    isClockwise = !isClockwise;
}