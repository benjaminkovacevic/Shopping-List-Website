# Shopping List Web Application

## Project Description

The goal of this project is to create a web application that serves as an electronic shopping list. The application will have three levels of access: guest, registered/user, and administrator.

### Guest
- Can view the provided information on the website.
- Can register on the website.

### Registered/User
- Can view the provided information on the website.
- Can update their profile information (password, name, surname, phone number, address).
- Can create a shopping list for one or more days.
- Can view, edit, and delete their shopping lists (with a display based on the list status - created and finished).
- Can view statistics on their most frequently purchased items within a specified time period.
- Can request a password change if forgotten.

### Administrator
- Can view all user accounts.
- Can approve/reject user registration requests.

User registration must be done securely by sending an activation link via email. The same email address cannot be used to register multiple accounts. Each email address must be unique and serves as the username.

To create a shopping list, the user enters the following details: list name, shopping day, list items (each item specified separately), and an optional description. The date and time of list creation should be automatically added. Each list is initially set to the "created" status and changes to "finished" after the shopping is completed.

When a user goes shopping, they can open the list and get a checklist of all the items. Each item should have a checkbox to mark whether it has been added to the cart. Pressing the "Finish Shopping" button will update the list status to "finished".

The user can access the "Statistics" option to select a time period and view the most frequently purchased or added items to their shopping lists.

The administrator section should be protected using sessions (PHP). All user passwords should be hashed using the bcrypt algorithm.

## Requirements and Guidelines

- In addition to the mandatory functionalities, students can add their own features to enhance the project.
- The use of an external JavaScript file is mandatory. The program code (variables, functions, objects, etc.) should be written in English, with comments in the code. Follow the instructions given in the coding_style_guide_sr.pdf file.
- The use of an external CSS file is mandatory.
- Connection parameters for the MySQL server should be defined in the external file db_config.php. Use the PDO extension for working with MySQL within the PHP language. A part of the PHP code must be object-oriented.
- Two students can work together on one project. Each team must have its own name.
- The project should be multiplatform (responsive) and adaptable to both computers and mobile devices.
- The following techniques and technologies should be used within the project: HTML, CSS, JavaScript, AJAX or Fetch API, JSON, Bootstrap, PHP, and MySQL.
- The PHP code that uses AJAX or Fetch API must manipulate data from the database. Recommended usage of AJAX or Fetch API techniques: data validation, data retrieval from the database, registration, and validation checks.
- Validations should be implemented on both the client and server sides for data validation pages.
- The project should be deployed on the school's web server. Each team will receive their access parameters via email.
- The use of other technologies, libraries, and APIs is optional.
