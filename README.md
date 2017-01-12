# HCPSS Staff Directory Web Application

## Overview

This is written using the Symfony Standard Edition bundles. The overall goal is to create a simple search experience for site users to find staff members at HCPSS central and annex offices, as well as school-level administrative staff. 

## Application Logic Goals 

1. Have data come directly from workday API via daily upload, which would be handled by IT. This data would be uploaded to a specific database and queried against in the application, rather than the application doing API calls to workday. 

2. Handle URLs inside controller based on database schema rather than hardcoded URLs. This will also be useful for generating department and school-level pages. 

3. Query the name, phone, location, and position, but omit middle initial data.

4. Have twig loop through and output individual staff records

5. Perform a security audit after basic functionality is complete. Ensure that all fields are free of XSS vulnerabilities and secured against SQL injection attacks. 

## UI Goals

1. Give application the ability to search for first and last names in search field.

2. Generate error messages for results not found. This would include the main hcpss phone line for names that are not found.

3. Allow users to look at department/school-level pages without having to search a person's name.

4. Display the number of matches. Highlight matched search results if user input contains a full or partial first or last name. 

### To dos:

- [x] Create a static front-end prototype for application to understand project scope
- [x] Create basic scaffolding for application using Symfony
- [x] Create dummy database for application tests from CSV upload. This also helps with requesting desired schema from IT department
- [x] Department option menu must be generated from department column in database
- [ ] Output error page for 404s
- [ ] Output error page when results are not found
- [ ] Dynamic routes for department pages
- [ ] Dynamic routes for school-level pages
- [x] Output for first and last name search
- [x] Output for first name search
- [x] Output for last name search
- [ ] Determine how to update names outside of workday API that persists to database and overrides workday upload
- [ ] Highlight searched terms in result output
- [ ] Generate unique error messages for results not found.
- [ ] Create a vagrant box for easily sharing development environment
- [ ] Come up with deployment strategy. Explore elastic beanstalk as a possibility
- [ ] Determine if this needs to be a separate domain (e.g., directory.hcpss.org)
