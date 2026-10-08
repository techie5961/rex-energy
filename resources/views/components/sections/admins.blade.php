@isset($css_var)
    <style class="css">
        :root{
    --primary-hsl:247;
    /* primary color */
    --primary:hsl(var(--primary-hsl),100%,65%);
    /* light primary color */
    --primary-light:hsl(var(--primary-hsl),100%,80%);
     /* light primary color */
    --primary-lighter:hsl(var(--primary-hsl),100%,90%);
      /* dark primary color */
     --primary-dark:hsl(var(--primary-hsl),100%,20%);
       /* darker primary color */
     --primary-darker:hsl(var(--primary-hsl),100%,10%);
       /* transparent of primary color */
    --primary-rgb:108, 92, 230;
     /* color on element with background as primary color */
    --primary-text-rgb:255, 255, 255;
    /* br primary */
      --br-primary:10px;
    /* rgt hex value for text */
      --rgt:0,0,0;
      /* text */
      --text:black !important;
      /* rgb hex value for background */
       --rgb:255, 255, 255;
    /* secondary */
      --secondary:rgb(108, 92,230);
    /* secondary rgb */
    --secondary-rgb:108, 92, 230;
    /* secondary hsl */
    --secondary-hsl:23;
    /* secondary light */
    --secondary-light:hsl(var(--secondary-hsl),50%,70%);
    /* secondary dark */
    --secondary-dark:hsl(var(--secondary-hsl),50%,30%);
    /* secondary text color */
    --secondary-text:white;
     /* background color */
     --bg:whitesmoke;
      /* light background color */
    --bg-light:white;
     /* lighter background color */
    --bg-lighter:white;
    /* bg-light rgb */
    --bg-light-rgb:255, 255, 255;
     /* text color */
    --text:white;
    
      }
      .cont{
    width:100%;
    height:50px;
    border:1px solid var(--rgt-01);
    border-radius:5px;
    display:flex;
    flex-direction:row;
    align-items:center;
    overflow:hidden;
}
/* badge */
.status{
    width:fit-content;
    height:fit-content;
    padding:0.3rem 0.9rem;
  
    user-select:none;
    font-weight:600;
    white-space:nowrap;

    
}
.status.green{
    background:rgba(0, 255, 0,0.1);
    color:#4caf50;
    border-radius:1000px;
}
.status.red{
    background:rgba(255, 0, 0, 0.1);
    color:#ff0d00;
    border-radius:1000px;
}
.status.gold{
    background:rgba(255, 145, 0, 0.1);
    color:rgb(124, 89, 0);
    border-radius:1000px;
}
.status.primary{
    background:var(--primary-02);
    color:var(--primary);
    border-radius:1000px;
}
.status.blue{
    background:rgba(0,0,255,0.2);
    color:blue;
    border-radius:1000px;
}
.c-green{
    color:#4caf50;

}
.c-red{
    color:red;
}
.c-gold{
    color:rgb(97, 70, 1);
}
.c-blue{
    color:blue;
}
     
/* modal */
.modal{
    position: fixed;
    top:0;
    left:0;
    bottom:0;
    right:0;
    background:rgba(0,0,0,0.4);
    z-index:4000;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:20px;
    display:none;


}
body:has(.modal.active){
    overflow:hidden !important;
}
.modal.active{
    display:flex;
}
.modal.active > .child{
    animation:animate-up 0.5s linear forwards;
    overflow:auto;
}
@keyframes animate-up{
    0%{
        transform:translateY(30px);
        opacity:0;
    }
    100%{
        transform:translateY(0);
        opacity:1;
    }
}
.modal > .child{
    border-radius:10px;
    display:flex;
    flex-direction:column;
    gap:10px;
    background:var(--bg-light);
    padding:20px;
    width:80%;
    max-width:500px;
    border:1px solid rgba(255,255,255,0.5);
    box-shadow:0 0px 10px rgba(0,0,0,0.3);

}   
    </style>
@endisset