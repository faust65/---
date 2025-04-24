let no=1
// const 상수 let 중복불가 var 
document.querySelector('#prev').addEventListener('click',()=>{
    no--
    if (no<1) no=1
        changeMain(no)
})
document.querySelector('#next').addEventListener('click',()=>{
    no++
    if (no>3) no=3
        changeMain(no)
})
const mainTxts=document.querySelectorAll('.main-txt')
const changeMain=(no)=>{
    let bg=`images/bg_main_visual_pc0${no}.jpg`
    document.querySelector('#wrap').style.backgroundImage=`url(${bg})`
    document.querySelector('#bgno').innerHTML=`${no}/3`
    mainTxts.forEach(e=>e.classList.remove('active'))
    document.querySelector('.main-txt-' + no).classList.add('active')
    document.querySelector('#prev').classList.remove('active')
    document.querySelector('#next').classList.remove('active')
    if (no===1){
        document.querySelector('#next').classList.add('active')
    }else if (no===2){
        document.querySelector('#prev').classList.add('active')
        document.querySelector('#next').classList.add('active')
    }else if (no===3){
        document.querySelector('#prev').classList.add('active')
    }
}
const tabs = document.querySelector('.tab')
const links=document.querySelector('.link-btns')
tabs.forEach(e=>e.addEventListener('click',()=> changeTabs(e)))

const changeTabs=(e)=>{
    tabs.forEach(e=>e.classList.remove('active'))
    e.classList.add('active')
    links.forEach(e=> e.classList.remove('active'))
    const tabNo=e.getAttribute('data-no')
    document.querySelector('.link-btns-'+tabNo).classList.add('active')
}