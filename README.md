# Title: WEBSITE MANAGEMENT WEBAPP

#### Demo link: <http://52.28.221.30/account/>

## Description

#### In this project, I developed a website management system with which you can do the following:

#### 1: Signup, login and recover password.

#### 2: Upload, edit and delete your website's images.

#### 3: Write, edit and delete your website's information such as: About-us, Our services, etc.

#### 4: View and analyze your visitors and users statistics. 5: An API to login and query the database.

#### Languages includes: PHP, MYSQL (PDO), Javascript, HTML5 and CSS.

## HOW TO USE:

### Database:

#### You'll need XAMPP runing PHP 8+, change the mysql username and password to (adminui,#J4dIg0Mn4PiJm0Ck4#) repectively, **change the db details in the phpmyadmin config file if you decide to use different details** .

### Recaptcha:

#### in the .env file create **SECRET_KEY** variable and assign it to your google recatcha secrect_key and also on line 8 in account.settings.js replace the site_key with yours.

### SMTP:

#### in the .env file create **SMTP_EMAIL** and **SMTP_PASS** variable and assign it to your own details.

### Host variable:

#### The **HOST** varible in config.php holds the root domain of the machine, replace it to match yours.

### Image folder variable:

#### The **Img_folder** varible in config.php holds the folder to store images, replace it to match yours.

### MAX REG variable:

#### The **MAX_REG** varible in config.php holds the number of users(admins) you want to allow.

### Visitors stats tracking

#### Add _require_once('includes/tracking.php');_ at the top of login.php or any other page/file of your choice, also, you can make a request to \*yourdomain/account/tracking.php to record a visit.

## FILES:

### **_config.php_**:

#### this file consists of the **global variables** and the database initialization.

### **_functions.php_**:

#### in this file are all of the shared functions, it requires the functionalities of _config.php_.

### **_index.php_**:

#### this is the main holder for all the pages, it switches between pages according to the value of the **action** and **subAction** from the url parameters **action** and **subAction** respectively, it requires the functionalities of _functions.php_, _includes/actions.php_, _includes/header.php_, _includes/footer.php_.

### **_login.php_**:

#### this file holds the login authentication logic, it requires the functionalities of _functions.php_.

### **_logout.php_**:

#### this file for session destruction and logging out of user, it requires the functionalities of _functions.php_.

### **_recorver-password.php_**:

#### this file is for password recovering, it requires the functionalities of _functions.php_.

### **_signup.php_**:

#### this file holds the signup authentication logic, it requires the functionalities of _functions.php_.

### **_tracking.php_**:

#### this file is for tracking and recording the informations of a visitor through their IP, it requires the functionalities of _functions.php_.

### **_api.handledata.php_**:

#### this file holds all the data manipulation logics like uploading, editing and deleting data, it requires the functionalities of _functions.php_.

### **_js/account.settings.js_**:

#### this file holds the javascript logics and functionalities like google recaptcha, sending xml requests to the backend, page intereactions, recording percentage difference of users and visitors statistics, and it requires some functionalities of _includes/footer.php_.

### **_css/account.style.css_**:

#### this file holds all the style of this program.

### **_includes/actions.php_**:

#### this file holds the functions to arrange and show the html of page and it's data as decided by **_index.php_** , it requires some functionalities of _functions.php_.

### **_includes/header.php_**:

#### this file holds the functions to show the **header** and **head** parts of the overall website, it requires some functionalities of _functions.php_ and _includes/tags.php_.

### **_includes/tags.php_**:

#### this file holds all the html **meta tags** and file links to be added in the **head** part of the overall website, this is to allow individual pages to have their own title.

### **_includes/footer.php_**:

#### this file holds all the **footer** part of the html and some javascript of the overall website.

### **_images_**:

#### this folder holds all the uploaded images.

### **_vendor_**:

#### this folder holds some php plugins like autoload and symphony.

### **_composer.lock & comsposer.json_**:

#### this is a php package for installing packages and plugins.

## How to use the API

### Login

#### To login, first you have to create an account on the webpage then provide the email and password as a json data e.g {"email":"johndoe@example.com","password":"testing12345"}, send a post request to http://52.28.221.30/account/api/login.php and you'll get a token (_the token expires in 48hours_). Example response const data = {"success":true,"message":"Login successful","access_token":"ac9e4fd897999fa3419bec77718de76c"}. With the Access Token, you can perform crud operations.

### Crud operations

#### This access is to logged in users only. For this, you'll have to send a **_Post_** request to http://52.28.221.30/account/handledata.php

#### Headers: for this operation to be successful, you'll have to set a header with the access token as the Authorisation, e.g const HEADERS = {"Content-Type": "application/json","Authorisation": "Bearer a3f714e812578a46d97f703ed2a99b59"}.

#### Request body: There are two main operations, Images and Texts, you should provide a json data in accordance to the operation.

#### Images:

#### **Image data**: const data = {"data": [{"old_name": "example.extension", "image_name": "example.extension", "image_blob": "constains the image base64 data", "xtension":to be specified if operation=upload}],"origin": "api_req", "type": "image", "category": "galleries", "sub_category": "to be specified (site-images,tatoos,paintings)", "operation": "to be specified (edit,delete,upload)","state": "changed"}

#### Texts:

#### **Text data**: const data = {"data": to be specified,"origin": "api_req","type": "textual","category":"about/services","sub_category": "to be specified","operation": "to be specified","state": "changed"}

### Getting data: to get data, send a **Get** request to http://52.28.221.30/account/api/readdata.php, specifying the **_action_**, **_sub action_**, **_page_** and **_limit_**.

#### **e.g request**: http://52.28.221.30/account/api/readdata.php?action=galleries&sub=site-images&page=0&limit=4,

#### **e.g response**: {'success': True, 'page': '0', 'limit': '4', 'total_data_count': 12, 'data_count': 4, 'data': [{'img_url': 'http://127.0.0.1/backend/account/images/site-images/favicon-sm.ico'}, {'img_url': 'http://127.0.0.1/backend/account/images/site-images/favicon-lg.ico'}, {'img_url': 'http://127.0.0.1/backend/account/images/site-images/23891556799905703.png'}, {'img_url': 'http://127.0.0.1/backend/account/images/site-images/youtube-circle-black.png'}]}
