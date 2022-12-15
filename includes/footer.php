</div>
<div class="alert-box"> 
</div>
<div class="confirm-box">
    <h2 id="header">Delete this image?</h2>
    <div class="options">
        <div class="cancel">No</div>
        <div class="save">Yes</div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo site_key;?>"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
<?php
            $site_key = site_key;
            $postUrl = HOST ."/api.handledata.php";
            $logoutUrl = HOST ."/logout.php";
            $track_url = HOST ."/tracking.php";
            $currentUrl = HOST ."/index.php?action=$action&sub=$subAction";
            echo "<script>
                let prev_data = {};
                let site_key = '$site_key';

                //neccessary urls
                const postUrl = '$postUrl';
                const  currentUrl =  '$currentUrl';
                const logoutUrl = '$logoutUrl';

                //visitors tracking url
                const t_url = '$track_url';
                
                const alertBox = document.querySelector('.alert-box');
                const confirmBox = document.querySelector('.confirm-box');
                const saveConfirm = confirmBox.querySelector('.save');
                const cancelConfirm = confirmBox.querySelector('.cancel');

                const ov_main = document.querySelector('.overlay-main');
                let data = {'data':[],'type':'image','category':'$action','sub_category':'$subAction','token':'','operation':'upload','state':'static'};
                
                cancelConfirm.addEventListener('click',()=>{
                    confirmBox.classList.toggle('show-alert');
                    ov_main.style.display = 'none';
                    document.body.classList.remove('noscroll');
                    data.data = [];
                });
                saveConfirm.addEventListener('click',()=>{
                    confirmBox.classList.toggle('show-alert');
                    ov_main.style.display = 'none';
                    document.body.classList.remove('noscroll');
                });
                </script>";

            if($action == 'about-services'){
                $old_data = json_encode($data);
                echo "<script>
                    const old_data = $old_data;
                    console.log(old_data);
                    data.type = 'textual';
                    data.operation = 'upload';";
                    if(isset($_GET['whattodo'])){
                        $op = $_GET['whattodo'];
                        echo "
                        const e_d = document.querySelector('#editor');
                        const editor = new EditorJS({
                            autofocus: true,
                            holder: 'editor',
                            tools:{
                                header: {
                                    class: Header, 
                                    inlineToolbar: ['link'] 
                                }, 
                                list: { 
                                    class: List, 
                                    inlineToolbar: true 
                                },
                                quote: Quote,
                            },
                            onChange:(api,event) => {
                                editor.save().then((outputData) => {
                                    data.data = (outputData.blocks);
                                    data.operation = '$op';
                                    data.state = 'changed';
                                    e_d.querySelector('.save-footer').classList.add('show');
                                }).catch((error) => {
                                    console.log('Saving failed: ', error)
                                });
                            }
                        });
                        ";
                    }
                    
                    echo "</script>";
            }else if($action === 'galleries'){
                echo "<script>
                    let image_data = {'old_name':'','image_name':'','image_blob':'','xtension':'jpeg'};
                    
                    const upload_img = document.querySelector('#upload-image');
                    let imgList = document.querySelector('#image-list');
                    let imgs = imgList.querySelectorAll('li');
                    const im_e = document.querySelector('#image-editor');
                    const cancel = im_e.querySelector('#cancel');
                    
                    const editImage = (e) =>{
                        const im_e = document.querySelector('#image-editor');
                        const save = im_e.querySelector('#save');
                        const img_input = document.querySelector('#img-input');
                        const t_area = im_e.querySelector('textarea');
                        const img_d = document.querySelector('#img-src');
                
                        editBtn = e.querySelector('.edit');
                        deleteBtn = e.querySelector('.delete');
                        
                        editBtn.addEventListener('click', ()=>{
                            data.operation = 'edit';
                            data.state = 'static';

                            save.innerText = 'Update';
                            im_e.querySelector('label').style.display = 'block';
                            img_input.removeAttribute('multiple');
                            let im_n = e.querySelector('img').getAttribute('src');
                            img_d.classList.remove('hide')
                            img_d.setAttribute('src',im_n);

                            im_n = im_n.split('/');
                            im_n = im_n[im_n.length - 1].split('?');
                            im_n = im_n[0];

                            let img_name = document.querySelector('#img-name');
                            img_name.innerText = im_n;
                            t_area.innerText =  im_n;
                            image_data.old_name =  im_n;
                            image_data.image_name =  im_n;
                            t_area.style.display = 'block';
                            ov_main.style.display = 'block';
                            im_e.style.display = 'block';
                            document.body.classList.add('noscroll');
                            
                            let xtension = img_name.innerText.split('.');
                            xtension = '.' + xtension[xtension.length - 1];
                            image_data.xtension = xtension;
                            
                            t_area.addEventListener('keyup',(e)=>{
                                let tmp_name = e.target.value;
                                tmp_name = tmp_name.replace(/\s+/g,'-');
                                img_name.innerText = tmp_name + xtension;
                                if(tmp_name.includes('.')){
                                    tmp_name = tmp_name.split('.');
                                    img_name.innerText = tmp_name[0] + xtension;
                                    t_area.value = tmp_name[0] + xtension;
                                    data.data[0].image_name = img_name.innerText.toLowerCase();
                                }
                                data.data[0].old_name =  im_n;
                                data.data[0].xtension = xtension;
                                data.data[0].image_name = img_name.innerText.toLowerCase();
                                data.state = 'changed';
                            })

                            data.data.push(image_data);
                            console.log(data.data);
                        })
                        
                        deleteBtn.addEventListener('click', ()=>{
                            data.operation = 'delete';
                            data.state = 'changed';

                           
                            let im_n = e.querySelector('img').getAttribute('src');
                            im_n = im_n.split('/');
                            im_n =im_n[im_n.length - 1].split('?');
                            im_n = im_n[0];

                            let xtension = im_n.split('.');
                            xtension = '.' + xtension[xtension.length - 1];
                            image_data.xtension = xtension;

                            image_data.old_name = im_n;
                            image_data.image_name = im_n;

                            data.data.push(image_data);
                            console.log(data.data);
                
                            ov_main.style.display = 'block';
                            document.body.classList.add('noscroll');
                            confirmBox.classList.toggle('show-alert');
                        });
                    }
    
                    upload_img.addEventListener('click',()=>{
                        data.operation = 'upload';
                        data.state = 'changed';

                        const img_input = document.querySelector('#img-input');
                        const t_area = im_e.querySelector('textarea');
                        const img_d = document.querySelector('#img-src');
                        const save = im_e.querySelector('#save');
                
                        save.innerText = 'Upload'
                        img_input.setAttribute('multiple',true);
                        img_d.classList.add('hide');
                        t_area.style.display = 'none';
                        ov_main.style.display = 'block';
                        im_e.style.display = 'block';
                        document.body.classList.add('noscroll');
                    })
                
                    cancel.addEventListener('click', ()=>{
                        ov_main.style.display = 'none';
                        im_e.style.display = 'none';
                        document.querySelector('#img-name').innerHTML = '';
                        document.querySelector('#img-src').setAttribute('src','');
                        document.querySelector('#img-name').innerText = '';
                        im_e.querySelector('textarea').innerText = '';
                        im_e.querySelector('textarea').style.display = 'none';
                        document.body.classList.remove('noscroll');
                        data.data = [];
                    })
                
                    const getImages = () =>{
                        const img_input = document.querySelector('#img-input');
                        let  e = data.operation;

                        img_input.addEventListener('change', () => {
                            let imN = Array.from(img_input.files);
                            let xtension;

                            console.log(imN)
                            e = data.operation;
                            console.log(e)

                            if(e == 'upload'){
                                imN.forEach(i =>{ 
                                    let image_data = {'image_name':'','image_blob':'','xtension':'jpeg'};
                                    let imgs = document.querySelector('#img-name');
                                    let li = document.createElement('li');
                                    let img_d = document.createElement('img');
                                    let i_filed = document.createElement('input');
                                    xtension = i.name.split('.');
                        
                                    i_filed.setAttribute('type','text');
                                    i_filed.setAttribute('value',i.name.replace(/\s+/g,'-'));
                        
                                    xtension = '.' + xtension[xtension.length - 1];
                                    image_data.xtension = xtension;
                        
                                    let i_v = i_filed.value.split('.');
                                    i_filed.value = i_v[0] + xtension;
                                    image_data.image_name = i_filed.value.replace(xtension,'').toLowerCase();
                        
                                    i_filed.addEventListener('keyup',()=>{
                                        i_filed.value = i_filed.value.replace(/\s+/g,'-');
                                        if(i_filed.value.includes('.')){
                                            i_v = i_filed.value.split('.');
                                            i_filed.value = i_v[0] + xtension;
                                        }
                                        image_data.image_name = i_filed.value.replace(xtension,'').toLowerCase();
                                    })
                                    const reader = new FileReader();
                                    reader.addEventListener('load',()=>{
                                        const img_src = reader.result;
                                        img_d.setAttribute('src', img_src);
                                        li.appendChild(img_d);
                                        li.appendChild(i_filed);
                                        imgs.appendChild(li);
                                        image_data.image_blob = img_src;
                                    });
                                    reader.readAsDataURL(i)
                                    data.data.push(image_data);
                                });
                            }else if(e == 'edit'){
                                const img_d = document.querySelector('#img-src');
                                imN = imN[0];
                                const reader = new FileReader();
                                reader.addEventListener('load',()=>{
                                    let img_name = document.querySelector('#img-name');
                                    img_src = reader.result;
                                    img_d.setAttribute('src', img_src);
                                    xtension = imN.name.split('.');
                                    xtension = '.' + xtension[xtension.length - 1];
                                    data.data[0].xtension = xtension;
                                    data.data[0].image_blob = img_src;
                                    data.operation = 'edit';
                                    data.state = 'changed';
                                });
                                reader.readAsDataURL(imN)
                            }
                        });
                    }

                    getImages();
                    imgs.forEach(e => {
                        editImage(e);
                    });
                    </script>";
                }else if($action === 'stats'){
                    echo 
                    "<script>
                    //visitors tracking data
                    prev_data ={
                        'type':'stats',
                        'total_visitors':$total_visitors,
                        'today_visitors':$today_visitors,
                        'this_month':$this_month
                    };
                    </script>";
                }else if($action === 'users'){
                    echo 
                    "<script>
                    //users tracking data
                    prev_data ={
                        'type':'users',
                        'total_users':$total_users,
                        'today_users':$today_users,
                        'this_month_users':$this_month_users
                    };
                    </script>";
                }
        ?>
    <script src="<?php echo HOST?>/js/account.settings.js?v=<?php echo time(); ?>"> </script>
</body>
</html>