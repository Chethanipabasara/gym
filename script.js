document.addEventListener("DOMContentLoaded", function(){
    function animateCounter (element, start, end, duration){
        let range = end - start;
        let current = start;
        let increment = range / (duration/ 16);
        let step = () =>{
            current += increment;
            if(current>=end){
                element.innerText= end;
            }else{
                element.innerText = Math.floor (current);
                requestAnimationFrame(step);
            }
        };
        step();
    }

    function startCounters(){
        let counters = document.querySelectorAll(".number");
        counters.forEach(counter=>{
            let endValue = parseInt(counter.textContent, 10);
            counter.textContent = "0";
            animateCounter(counter,0,endValue, 2000)
        });
    }

    let section = document.querySelector(".count");
    let observer = new IntersectionObserver((entires, observer)=>{
        entires.forEach(entry=>{
            if(entry.isIntersecting){
                startCounters();
                observer.unobserve(entry.target);
            }
        });
    },{threshold:0.5});
    observer.observe(section);



    const menuToggle = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");
    const closeBtn = document.getElementById("close-btn");

    menuToggle.addEventListener("click", function(){
        sidebar.classList.toggle("active");
    });
    closeBtn.addEventListener("click", function(){
        sidebar.classList.remove("active");
    });
});


