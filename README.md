# HCPSS Staff Directory Web Application

## Overview

This is written using the Symfony Standard Edition bundles. The overall intention is to create a simple search experience for site users to find staff members at HCPSS central and annex offices.

## Updating Directory

Under notifications in Workday, four files will be automatically uploaded every Monday morning. One is for teminated employees, another for new employees, and two more for employees with contact data change. 

### New or teminated employees

Inside the SQL file (or PHPmyadmin interface), add the new employees based on what's inside workday and remove the terminated ones. For new employees, assign them the next ID number and match up their department ID with their department. If they're in two different departments, add them twice with different numbers in the ID column. 

### Existing employees

If an employee make any edits to their file they will show up in the two CSVs related to data changes. Search for the employee's e-number in Workday, and compare the data against what's already in the database. Be sure to check and see if they've switched departments. Sometimes, there won't be any changes and that's by design, Workday sends data even if an employee just hits save without changing anything. 

### New departments

If there's a new department, assign the next ID number which will be used for associations between the staff in that department and the ID (many to one in Doctrine schema). Add a relevant slug, the name, location, and the description is optional. The description field will show up on the department's page and can link out to related departments. Those URLs are not dynamic and have to be manually added. 

All new departments will be added to the departments page in alphabetical order. 

## Updating Schema

Any manual changes to the Staff.php or Departments.php file (which modifies the database) can be applied using the `php app/console doctrine:schema:update --force` command. 

### SQL query for moving phone data

If needed again, the SQL to move all the phone data from one column to another with the hyphens dropped is 
``` sql
UPDATE `staff` SET `phone_plain` = REPLACE(phone, '-', '')
```
