# do-spaces-api

1.Set up PHP and Apache:

Ensure XAMPP is running with Apache and PHP services started.
Place your API script in the htdocs folder (usually C:\xampp\htdocs).


2.Install Composer:

Download and install Composer from https://getcomposer.org/download/
Follow the installation wizard, making sure to select the PHP from your XAMPP installation.


3.Create a new project directory:

Open Command Prompt
Navigate to your htdocs folder: cd C:\xampp\htdocs
Create a new directory: mkdir do-spaces-api
Enter the directory: cd do-spaces-api

4. Initialize a new Composer project:

Run: composer init
Follow the prompts, you can accept the defaults for most options.

This step might error maybe becuase composer is already initialed in another places. If there is an error, continue to step 5.

5. Install the AWS SDK for PHP:

Run: composer require aws/aws-sdk-php


6. Create your PHP script:

Create a new file named upload.php in your project directory.
Copy the code into this file.


7. Configure DigitalOcean Spaces:

Sign in to your DigitalOcean account.
Create a new Space if you haven't already.
Generate API keys (Access Key and Secret Key) for Spaces.
Update the PHP script with your Space name, region, Access Key, and Secret Key.


8. Test your API:

Ensure Apache is running in XAMPP.
Use a tool like Postman or write a simple HTML form to test file uploads to your API.

To test the API, you'll need to send a POST request with an image file. Here are a few ways to do this:
a. Using HTML form (for simple testing):
Create a file named test.html in the same directory with this content:
htmlCopy<!DOCTYPE html>
<html>
<body>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="image" id="image">
    <input type="submit" value="Upload Image" name="submit">
  </form>
</body>
</html>
Then access http://localhost/do-spaces-api/test.html in your browser to use this form.
b. Using Postman (for more advanced testing):

Open Postman.
Set the request type to POST.
Enter the URL: http://localhost/do-spaces-api/upload.php
Go to the "Body" tab.
Select "form-data".
Add a key named "image" and select "File" as the type.
Choose an image file from your computer.
Click "Send" to make the request.

Additional performance improvement

Configure PHP settings:

1.Open php.ini (usually in C:\xampp\php\php.ini)
Ensure file uploads are enabled: file_uploads = On
Set appropriate upload size limits: upload_max_filesize = 10M and post_max_size = 10M


2.Restart Apache:

After making changes to php.ini, restart the Apache service in XAMPP.