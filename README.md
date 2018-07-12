# HCPSS Staff Directory Web Application

## Overview

This is written using the Symfony Standard Edition bundles. The overall intention is to create a simple search experience for site users to find staff members at HCPSS central and annex offices.

### Useful commands and other things

#### Updating Schema

Any manual changes to the Staff.php or Departments.php file (which modifies the database) can be applied using the `php app/console doctrine:schema:update --force` command. 

### SQL query for moving phone data

If needed again, the SQL to move all the phone data from one column to another with the hyphens dropped is `UPDATE `staff` SET `phone_plain` = REPLACE(phone, '-', '')`
