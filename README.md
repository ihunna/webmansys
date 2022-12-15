# Title: WEBSITE MANAGEMENT WEBAPP
#### Demo link:  <http://52.28.221.30/account/>

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

### Host variable:
#### The **HOST** varible in config.php holds the root domain of the machine, replace it to match yours.

### Image folder variable:
#### The **Img_folder** varible in config.php holds the folder to store images, replace it to match yours.

### MAX REG variable:
#### The **MAX_REG** varible in config.php holds the number of users(admins) you want to allow.

### Visitors stats tracking
#### Add *require_once('includes/tracking.php');* at the top of login.php or any other page/file of your choice, also, you can make a request to *yourdomain/account/tracking.php to record a visit.

## FILES:

### ***config.php***:
#### this file consists of the **global variables** and the database initialization.

### ***functions.php***:
#### in this file are all of the shared functions, it requires the functionalities of *config.php*.

### ***index.php***:
#### this is the main holder for all the pages, it switches between pages according to the value of the **action** and **subAction** from the url parameters **action** and **subAction** respectively, it requires the functionalities of *functions.php*, *includes/actions.php*, *includes/header.php*, *includes/footer.php*.

### ***login.php***:
#### this file holds the login authentication logic, it requires the functionalities of *functions.php*.

### ***logout.php***:
#### this file for session destruction and logging out of user, it requires the functionalities of *functions.php*.

### ***recorver-password.php***:
#### this file is for password recovering, it requires the functionalities of *functions.php*.

### ***signup.php***:
#### this file holds the signup authentication logic, it requires the functionalities of *functions.php*.

### ***tracking.php***:
#### this file is for tracking and recording the informations of a visitor through their IP, it requires the functionalities of *functions.php*.

### ***api.handledata.php***:
#### this file holds all the data manipulation logics like uploading, editing and deleting data, it requires the functionalities of *functions.php*.

### ***js/account.settings.js***:
#### this file holds the javascript logics and functionalities like google recaptcha, sending xml requests to the backend, page intereactions, recording percentage difference of users and visitors statistics, and it requires some functionalities of *includes/footer.php*.

### ***css/account.style.css***:
#### this file holds all the style of this program.

### ***includes/actions.php***:
#### this file holds the functions to arrange and show the html of page and it's data as decided by ***index.php*** , it requires some functionalities of *functions.php*.

### ***includes/header.php***:
#### this file holds the functions to show the **header** and **head** parts of the overall website, it requires some functionalities of *functions.php* and *includes/tags.php*.

### ***includes/tags.php***:
#### this file holds all the html **meta tags** and file links to be added in the **head** part  of the overall website, this is to allow individual pages to have their own title.

### ***includes/footer.php***:
#### this file holds all the **footer** part of the html and some javascript of the overall website.

### ***images***:
#### this folder holds all the uploaded images.

### ***vendor***:
#### this folder holds some php plugins like autoload and symphony.

### ***composer.lock & comsposer.json***:
#### this is a php package for installing packages and plugins.