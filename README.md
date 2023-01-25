# GitHub Timeline assignment

This is a GitHub timeline newsletter. Anyone can subscribe this newsletter and will get latest update of GitHub timeline after every 5 minutes. 



## Tools and Requirements

- **MailHog** is an email service which is used to test the email. It shows all email sent by app. It also prevents mails from sending it to actual email address.
- **MariaDB** is database service used in this app.
- Install the `lando` development environment to run project.
- Use `phpcs` extension to setup the PHP Code Sniffer.


## Installation

- This project is built using `lando` development environment.
- Run `lando start` to deploy the docker containter and bring the project live. This command also show the URLs for different sevices like nginx appserver, mailhog, and mariadb. Use those URLs to get live demo.
- Run `lando destroy` to delete the docker containter and project.
- If you want to just pause the process and want to preserver data, then use `lando stop` and `lando restart` instead of above command.
- `lando ssh` to get the endpoint of server cli.
- `lando info` to get URL of different services provided by lando.

## Modules 

- `DBConnection` is used to connect database. It provides different functions to manipulate database.
- `Subscribe` is used to give subscription to user. It also includes the input validation. It sends a verification email to user. 
- `Verification` is used to verify the user. After verification user will get the GitHub timeline update after every 5 minutes.
- `Unsubscribe` provides a functionality to unsubscribe the newsletter.
- `DataFetcher` fetches data from the url [github.com/timeline](https://github.com/timeline). It also reconstructs the data by removing unnecessary data.
- `EmailSender` get data from `DataFetcher` and sends the email to every subscriber.
- All data validation is done by respect modules before processing it.

## Workflow

- All modules handels respected request and process the data after validation.
- User can subscribe the newsletter using web portal. Use the links provided in emails to verify and unsubscribe.
- There is also a script `email_sender` which is executed after every 5 minute using cron service.
- cron log is generated in `cron_email_sender.log` file with timestamp to ensure that whether the error generated in the script execution or not.
- A template is also used to embed the fetched data and send it in email. Template has few stylesheets taken from GitHub source code to beautify content.

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
    - [x] Add GitHub stylesheets in email template

- [ ] Future work (suggestions)
    - [ ] Send token with hashing
    - [ ] Create new module for validation

## Skeleton

```
.
├── README.md
├── Skeleton.md
├── cron.txt
├── cron_jobs
│   └── email_sender.php
├── includes
│   ├── DBConnection.class.php
│   ├── DataFetcher.class.php
│   ├── EmailSender.class.php
│   ├── Subscribe.class.php
│   ├── Unsubscribe.class.php
│   └── Verification.class.php
├── phpcs.xml
├── public
│   ├── assets
│   │   ├── GitHub_Logo.png
│   │   └── github-mark.svg
│   ├── css
│   │   ├── log.style.css
│   │   └── style.css
│   ├── index.php
│   ├── unsubscribe.php
│   └── verify.php
└── template
    └── gh_timeline.html
```

## Author

Name: [Utsav Ladani](https://github.com/Utsav-Ladani) \
Company: [rtCamp](https://github.com/rtCamp) 
