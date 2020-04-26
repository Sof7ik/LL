//кнопка "Покупатели"
document.querySelectorAll("a.select")[0].addEventListener('click', function () {

    document.querySelector('div.buttonsCustomers').style.display = 'flex';
    document.querySelector('div.buttonsProducts').style.display = 'none';

    //покупатели
    document.querySelector('table.customers').style.display = 'block';
    document.querySelector('table.customers').style.opacity = 1;
    
    //кнопки разноцветные
    document.querySelector('a.add').style.display = 'block';
    document.querySelector('input.delete').style.display = 'block';
    document.querySelector('a.change').style.display = 'block';
    document.querySelector('a.buy').style.marginLeft = '1%';

    //карты
    document.querySelector('table.cards').style.display = 'none';
    document.querySelector('table.cards').style.opacity = 0;

    //товары
    document.querySelector('table.products').style.display = 'none';
    document.querySelector('table.products').style.opacity = 0;
})

//кнопка "Карты"
document.querySelectorAll("a.select")[1].addEventListener('click', function () {
    //покупатели
    document.querySelector('table.customers').style.display = 'none';
    document.querySelector('table.customers').style.opacity = 0;

    //кнопки разноцветные
    document.querySelector('a.add').style.display = 'none';
    document.querySelector('input.delete').style.display = 'none';
    document.querySelector('a.change').style.display = 'none';
    document.querySelector('a.buy').style.marginLeft = '0%';

    document.querySelector('div.buttonsCustomers').style.display = 'none';
    document.querySelector('div.buttonsProducts').style.display = 'none';

    //карты
    document.querySelector('table.cards').style.display = 'block';
    document.querySelector('table.cards').style.opacity = 1;

    //товары
    document.querySelector('table.products').style.display = 'none';
    document.querySelector('table.products').style.opacity = 0;
})

//кнопка "Товары"
document.querySelectorAll("a.select")[2].addEventListener('click', function () {
    //покупатели
    document.querySelector('table.customers').style.display = 'none';
    document.querySelector('table.customers').style.opacity = 0;
    
    document.querySelector('div.buttonsCustomers').style.display = 'none';
    document.querySelector('div.buttonsProducts').style.display = 'flex';
    
    //кнопки разноцветные
    document.querySelector('a.add').style.display = 'block';
    document.querySelector('input.delete').style.display = 'block';
    document.querySelector('a.change').style.display = 'block';
    document.querySelector('a.buy').style.marginLeft = '1%';

    //карты
    document.querySelector('table.cards').style.display = 'none';
    document.querySelector('table.cards').style.opacity = 0;

    //товары
    document.querySelector('table.products').style.display = 'block';
    document.querySelector('table.products').style.opacity = 1;
})