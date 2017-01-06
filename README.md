# HCPSS Staff Directory Web Application

## Overview

This is written using the Symfony Standard Edition. The overall goal is to create a simple search experience for site users to find staff members at HCPSS central and annex offices, as well as school-level administrative staff. 

## Application Goals 

1. Have data come directly from workday API via daily upload, which would be handled by IT. This data would be uploaded to a specific database and queried against in the application, rather than the application doing API calls to workday. 

2. Handle URLs inside controller based on database schema rather than hardcoded URLs. This will also be useful for generating department and school-level pages. 

3. Query the name, phone, location, and position, but omit middle initial data.

4. Have twig loop through and output individual staff records

## UI Goals

1. Give application the ability to search for first and last names in search field, as well as department and schools. Users will have the flexibility to search using all fields or just one.

2. Generate unique error messages for results not found. This would include either the main hcpss phone line for names that are not found, or department/school-level phone numbers for when a user provides those specific search parameters.

3. Allow users to look at department/school-level pages without having to add a person's name.

4. Display the number of matches. 

### To dos:

- [x] Create a static front-end prototype for application to understand project scope
- [x] Create basic scaffolding for application using Symfony
- [x] Create dummy database for application tests from CSV upload. This also helps with requesting desired schema from IT department
- [x] Department option menu must be generated from department column in database
- [ ] School option menu must be generated from department column in database 
- [ ] Output error page for 404s
- [ ] Output error page when results are not found
- [ ] Dynamic routes for department pages
- [ ] Dynamic routes for school-level pages
- [ ] Output for first and last name search
- [ ] Output for first name search
- [ ] Output for last name search
- [ ] Determine how to update names outside of workday API that persists to database and overrides workday upload
- [ ] Highlight searched terms in result output
- [ ] Generate unique error messages for results not found.
