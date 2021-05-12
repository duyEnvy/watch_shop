console.log('asdadsd');
const dashboard = document.querySelector('#dashboard');
const listproduct = document.querySelector('#click-list');

listproduct.addEventListener('click', function(){
    listproduct.style.display = 'block';
    dashboard.style.display = 'none';
})