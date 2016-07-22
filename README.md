# esomo
Elearning platform for highschool students in Kenya(8-4-4 and IGCSE)

Features - feature list to be updated

# Project Breakdown

The project is divided into two sections : 
# USER/STUDENT SECTION (host/brookhust/)
- This allows students to view educational material relevant to the subjects/courses offered.
- It is divided into 6 different pages.
- *home* is basic information about the website and can be modified by the frontend developer

- *learn* contains a  list of available subjects each with a button allowing you to view content relevant to that subject. On clicking the button you get to choose a grade after which you view the content for the grade/subject.

- *assignments* is where logged in users get assignments sent by teachers to their class. It contains relevant assignment information such as due date and teacher who sent as well as a download button which downloads the relevant content whenever available

- *tests* is where any past papers will be stored. Logged in users can then download past papers for revision from here. Note this is going to be the last thing to be implemented

- *login/signup* allows the user to login or signup if not already logged in. If they are logged in then there is a logout button in their place which allows the user to log out of their account.

- *forgot* is the page someone goes to if they have forgotten their password, it will allow for an email to reset the password to be sent. (among last things to do)

# ADMIN SECTION (host/brookhurst/admin)
The admin section is used to manage content and view statistics. 
The admin section content is based on access levels, where only certain levels can access different levels of content.
The access levels are : 
  1 - none (new admin signup defaults to access level 1, so they need their account to be approved)
  2 - content creator (can only add content for studying)
  3 - teacher (can send assignments + all lower tasks)
  4 - principal (can view statistics on teachers)
  5 - superuser(can change access level of everyone
  
- It is divided into 5 side navigation items
- *content* - allows adding study content
- *assignments* - allows sending and cancelling of assignments
- *profile* - shows basic information about the logged user and will allow changing of emails
- *schedules* - allows teachers to schedule classes so that their performance can be monitored
- *statistics* - shows all the teachers' performance and schedules - should have a filter option

#FILE STRUCTURE
brookhurst/ - Folder contains all files. Anything not in the admin folder almost certainly belongs to the user section or both.  /css contains the css styling for this section
brookhurst/admin - Folder contains admin related files. /css contains the css styling for this section

# FRONT-END KNOWLEDGE
The project uses twitter bootstrap as a base for a responsive layout. 
- Please do not adjust margins unless necessary as this may mess up the media queries used by bootstrap
- For students/user files - main.css(*add your styles here*) is the styling  information and theme.min.css is the extension of bootstrap
- For admin files - main.css in the admin/css folder is the styling information (*add your styles here*)
