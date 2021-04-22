SakuraCommerce - ecommerce platform based on Yii2 PHP Framework
===============================



1. Clone from https://github.com/nurbeknurjanov/yii2ecommerce
2. Run: composer install
3. Do 3 virtual hosts

    • 3.1 for frontend -> to the frontend/web<br>
    • 3.2 for backend -> to the backend/web<br>
    • 3.3 for images -> frontend/web/upload<br>
    • The last one is important. Else you can't see your images. 
      The reason is to make fast your site, you can use cdn domain for your images.<br>
    • Here is important rule is:<br>
    • if you have your domain yourdomain.com, so then your image virtual host must be in this format img.yourdomain.com<br>
    • Backend backend.yourdomain.com

4. Create 3 databases

    • 4.1 your_local_db, import sakura.sql here<br>
    • 4.2 your_local_db_test - this is for testing, import sakura.sql here too<br>
    • 4.3 countries, import countries.sql here
    
5. Do changes in this files

    • 5.1 common/config/main-local.php to your local databases<br>
    • common/config/main.php line 100-112 to your server databases<br>
    • 5.2 tests/codeception/config/test-merged.php line 3 
    instead of sakuracommmerce.com paste here your real domain. 
    It is for to know are you in prod or env<br>
    • 5.3 tests/_support/Helper/Unit.php line 20 to read images<br>
    • 5.4 tests/codeception/config/test.php line 21-25 
    • here is your test databases, first is on your server, the second is on your local computer<br>
    • 5.5 tests/acceptance.suite.yml line 20, to your local test database<br>
    • 5.6  tests/acceptance.suite.yml line 7 and 16, set here your local url for frontend, example http://yourdomain.com
      
6. <br>

    • 6.1 Run: php yii migrate<br>
    • It does changes to your_local_db and uploads the images<br>
    • Then change common/config/main-local.php to sakura_test db. Run php yii migrate again. It does changes to sakura_test db. Then return back to sakura db in  common/config/main-local.php file.<br>
    • 7.2 run: php yii fixture "*" <br>
    • this inserts test data and images<br>
    • 7.3 php yii clean – to clean assets files. It may asks sudo permissions.<br>
    • 7.4 php yii minify/all – this command is important, to make fast your site, you need to compress all js and css files into all.css and all.js files.<br>
    • 7.5 After you have run minify command, <br>
    go to frontend/config/main.php – 65 line, comment the line, 
    and uncomment 68 line, it lets AssetManager to use AllAssetBundle, 
    I mean instead of loading a lot of js and css files from assets, 
    there will be only 2 compressed files, all.js and all.css. <br>
    Also don't forget going to common/config/main.php – line 294, 
    to make 'forceCopy'=>false, it stop assets refresh assets files.<br>
    • sudo chmod -R 777 frontend/web/assets/*

7. Make sure your these directories are writable

    frontend/web/assets/<br>
    frontend/web/upload<br>
    frontend/web/tmp<br>
    frontend/web/editor_upload<br>
    backend/web/assets/<br>
    backend/runtime<br>
    frontend/runtime<br>
    
    If not make them writable<br>
    
    sudo chmod -R 777 frontend/web/assets/*
      


8. Open in browser http://yourdomain.com 
    
    check your site is working, images are shown, then check backend too http://backend.yourdomain.com, be sure that images are showing

9. If everything is ok, then check your codeception tests are working too

    • 9.1 Unit tests run this: vendor/bin/codecept run unit<br>
    • If it is ok, check how acceptance tests working<br>
    <br>
    • 9.2 To check acceptance tests<br>
    • Install on your database java. <br>
    • Then run this: java -jar project_root/selenium.jar<br>
    • You must see this kind of message<br>
    <br>
     14:24:45.925 INFO [GridLauncherV3.launch] - Selenium build info: version: '3.14.0', revision: 'aacccce0'<br>
     14:24:45.926 INFO [GridLauncherV3$1.launch] - Launching a standalone Selenium Server on port 4444<br>
     2018-10-31 14:24:46.063:INFO::main: Logging initialized @609ms to org.seleniumhq.jetty9.util.log.StdErrLog<br>
     14:24:46.332 INFO [SeleniumServer.boot] - Selenium Server is up and running on port 4444<br>
    
    <br>
    • Be sure it is working. If not,<br>
    •  a) Install latest version of selenium, https://www.selenium.dev/downloads/<br>
    •  b) Install latest version of Chrome<br>
    •  c) Copy project_root/chromedriver to your local computer. Or install latest version of https://chromedriver.chromium.org/downloads, in ubuntu it is /usr/local/bin/chromedriver. Learn it for windows.<br>
    •  d) Then try again java -jar selenium.jar <br>
    • If your selenium works<br>
    • Run this:vendor/bin/codecept run acceptance<br>


DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```
