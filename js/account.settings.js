window.addEventListener('load',()=>{
    //checking users impression difference
    check_imp_diff(prev_data);
    try{
        //google recatpcha
        grecaptcha.ready(function() {
            grecaptcha.execute(site_key, {action: 'submit'}).then(function(token) {
                data.token = token;
            });
        });
    }catch(error){
        console.log(error);
    }
    const sendRequests = (method,url,payload,operation) =>{
        try{
            const ov = document.querySelector('.overlay-main');
            const loader = document.querySelector('.loader');
            const pro = loader.querySelector('.progress');
            const proBar = loader.querySelector('.progress-bar');
            const im_e = document.querySelector('#image-editor');
            try{
                im_e.style.display = 'none';
            }catch(err){
                console.log(err);
            }
    
            document.body.classList.add('noscroll');
            ov.style.display ='flex';
            loader.style.display ='flex';
    
            const promise = new Promise((res,rej)=>{
                let xhr = new XMLHttpRequest();
                xhr.open(method,url,true);

                if(operation === 'upload'){
                    xhr.setRequestHeader('Content-Type','application/json')
    
                    xhr.upload.onprogress = (ev) =>{
                        if (ev.lengthComputable) {
                            var percentComplete = (ev.loaded/ev.total)*100;
                            setTimeout(() => {
                                percentComplete = Math.floor(percentComplete);
                            },2000);
                            proBar.style.width = percentComplete + '%';
                        }
                    }
                }else{
                    proBar.style.width = 10 + '%';
                    pro.classList.add('animate');
                }
    
                xhr.onload = () =>{
                    if(xhr.status >= 400){
                        rej(xhr.response);
                    }else{res(xhr.response);}
                }
                xhr.onerror = () =>{
                    rej('Error sedning request')
                }
                
                xhr.send(JSON.stringify(payload));
            });
            setTimeout(()=>{
                pro.classList.remove('animate');
                loader.style.display = 'none';
                ov.style.display = 'none';
                document.body.classList.remove('noscroll');
            },2000)
            return promise;
        }catch(err){
            console.log(err);
        }
    }
    const aL = document.querySelectorAll('.side-bar-item-btn');
    aL.forEach(li => {
        const ul = li.parentElement.querySelector('.side-bar-submenu');
        li.addEventListener('click',(e)=>{
            icon =  li.firstElementChild.classList.value;
            if(icon === 'fa-solid fa-angle-down '){
                li.firstElementChild.classList.replace('fa-angle-down','fa-angle-up');
            }else{
                li.firstElementChild.classList.replace('fa-angle-up','fa-angle-down');
            }
            ul.classList.toggle('show');
        })
    });

    const pL = document.getElementById('profile-link');
    const sP = document.getElementById('short-p-details');
    pL.addEventListener('click',()=>{
        sP.classList.toggle('show');
    });
    pL.addEventListener('mouseenter',()=>{
        sP.classList.toggle('show');
    });

    const sm = document.getElementById('menu-btn');
    const ms = document.querySelector('.menu-sm');
    
    sm.addEventListener('click', ()=>{
        ms.classList.toggle('overlay');
        sm.style.zIndex = '3';
        document.body.classList.toggle('noscroll');
        ms.classList.toggle('show-flex');
        ms.querySelector('.side-bar-sm').classList.toggle('slide-in');
    });

    const ov = ms.querySelector('.overlay');
    ov.addEventListener('click', ()=>{
        ms.classList.toggle('overlay');
        document.body.classList.remove('noscroll');
        ms.classList.toggle('show-flex');
        ms.querySelector('.side-bar-sm').classList.toggle('slide-in');
    });

    const logoutBtn = document.querySelectorAll('.logout');
    const aSB = document.querySelectorAll('.save');
    aSB.forEach(sB =>{
        sB.addEventListener('click',()=>{
            request('POST');
        });
    });

    logoutBtn.forEach(lBtn =>{
        lBtn.addEventListener('click',()=>{
            try{
                document.querySelector('#menu-btn').click();
            }catch(err){
                
            }
            request('GET');
        });
    });


    const request = (method) => {
        grecaptcha.ready(function() {
            grecaptcha.execute(site_key, {action: 'submit'}).then(function(token) {
                data.token = token;
            });
        });
        let r_data;
        if(method === 'POST'){
            if(data.data.length > 0 && data.state !== 'static'){
                const operation = data.operation;
                sendRequests(method,postUrl,{data},operation).then((response)=>{
                    r_data = JSON.parse(response);
                    console.log({success:r_data.success,message:r_data.message});
                    alertBox.innerHTML = `<span style="color: #fff; font-weight: 500">Hello:</span>&nbsp; ${r_data.message}`;
                    alertBox.classList.toggle('show-alert');
                }).then(()=>{
                    setTimeout((res) => {
                        alertBox.classList.toggle('show-alert');
                    },5000);

                    setTimeout((res) => {
                        if(r_data.success){
                            data.data = [];
                            window.location.replace(currentUrl);
                        }
                    },6000);
                    
                }).catch(err =>{
                        console.log(err)
                        err = JSON.parse(err);
                        console.log(err);
                        alertBox.style.backgroundColor = '#ff3860'
                        alertBox.innerHTML = `<span style="color: #fff; font-weight: 500">Hello:</span>&nbsp; ${err.message}`;
                        alertBox.classList.toggle('show-alert');
                        setTimeout(()=>{
                            alertBox.classList.toggle('show-alert');
                            alertBox.style.backgroundColor = '#09c372';
                            data.data = [];
                        },5000);
                });
            }else{
                alertBox.style.backgroundColor = '#ff3860'
                        alertBox.innerHTML = `<span style="color: #fff; font-weight: 500">Hello:</span>&nbsp; No data to send`;
                        alertBox.classList.toggle('show-alert');
                        setTimeout(()=>{
                            alertBox.classList.toggle('show-alert');
                            alertBox.style.backgroundColor = '#09c372';
                        },5000);
                console.log('No data to send')
            }
        }else if(method === 'GET'){
            sendRequests(method,logoutUrl,{},'logout').then((response)=>{
                res = JSON.parse(response);
                console.log({message:res.message});
                alertBox.innerHTML = `<span style="color: #fff; font-weight: 500">Hello:</span>&nbsp; ${res.message}`;
                alertBox.classList.toggle('show-alert');
            }).then(()=>{
                setTimeout(() => {
                        alertBox.classList.toggle('show-alert');
                        window.location.replace(currentUrl);
                    },5000);   
            }).catch(err =>{
                    err = JSON.parse(err);
                    console.log(err);
                    alertBox.style.backgroundColor = '#ff3860'
                    alertBox.innerHTML = `<span style="color: #fff; font-weight: 500">Hello:</span>&nbsp; ${err.message}`;
                    alertBox.classList.toggle('show-alert');
                    setTimeout(()=>{
                        alertBox.classList.toggle('show-alert');
                        alertBox.style.backgroundColor = '#09c372';
                    },5000);
            });
        }
    }
});

const check_imp_diff = (new_data) =>{
    //getting visitors data in local storage to calculate % diff
    const prev_data = JSON.parse(localStorage.getItem(new_data.type));
    if(prev_data){
        Object.keys(prev_data).forEach(k =>{
            if(k === 'type') {return};
            const diviver = (prev_data[k] > 0)? prev_data[k]:new_data[k]
            let diff = (diviver != 0)? Math.round(((new_data[k] - prev_data[k]) / diviver) * 100) : 0;
            if(!diff) {return};
            pcent = document.getElementById(k).querySelector('.pcent');
            pcent.style.color = (diff < 0)? '#ff3860':'#059255';
            diff = (diff > 0)? `+${diff}%`: `${diff}%`;
            pcent.innerText = diff;
        });
    }else{
        console.log('no prev data')
    }
    //saving visitors data in local storage to calculate % diff
    localStorage.setItem(new_data.type, JSON.stringify(new_data));

}