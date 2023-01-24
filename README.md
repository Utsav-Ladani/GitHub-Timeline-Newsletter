# GitHub Timeline assignment

This is a GitHub timeline subscription. User with subscription will get latest update of GitHub timeline after every 5 minutes.

## Installation

- `lando start` to deploy the docker containter and bring the project live. This command also show the URLs for different sevices like nginx appserver, mailhog, and mariadb. Use those URLs to get live demo.
- `lando destroy` to delete the docker containter.

## Progress

- [x] Backend
    - [x] Database Connection
    - [x] Subscribe
    - [x] Token verification
    - [x] Unsubscribe
    - [x] Fetch GitHub timeline latest update
    - [x] Cron job to send emails
    - [x] Write email template

- [x] Frontend
    - [x] Subscribe page
    - [x] Unsubscribe page
    - [x] Token verification page

- [x] Improvements
    - [x] Make UI more beautiful
    - [x] Add namespace
    - [x] Write documentation

## About us

Name: Utsav ladani \
Company: rtCamp \
Project: GitHub Timeline assignment
