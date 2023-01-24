# GitHub Timeline assignment

This is a GitHub timeline subscription. User with subscription will get latest update of GitHub timeline after every 5 minutes.

## Installation

- `lando start` to deploy the docker containter and bring the project live. This command also show the URLs for different sevices like nginx appserver, mailhog, and mariadb. Use those URLs to get live demo.
- `lando destroy` to delete the docker containter.

## Progress

- [ ] Backend
    - [x] Database Connection
    - [x] Subscribe
    - [x] Token verification
    - [x] Unsubscribe
    - [x] Fetch GitHub timeline latest update
    - [x] Cron job to send emails
    - [x] Write email template

- [ ] Frontend
    - [x] Subscribe page
    - [x] Unsubscribe page
    - [x] Token verification page

- [ ] Improvements
    - [ ] Make UI more beautiful
    - [ ] Add namespace
    - [ ] Write documentation

## About us

Name: Utsav ladani \
Company: rtCamp \
Project: GitHub Timeline assignment
