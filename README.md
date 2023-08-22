<p align="center">
  <a href="https://www.labuelanorma.com" target="_blank">
    <img src="https://www.labuelanorma.com/server/public/Logo.png" width="200">
  </a>
</p>

# Dashboard Web Management

This Backend application is developed to connect with the Front-End Web [LaAbuelaNorma](https://www.labuelanorma.com).
Welcome to the Dashboard Web Management project! This dashboard is designed to serve as a web application for effectively managing the web content for the web LaAbuelaNorma. Admin can create content, giveaways and sell products on the front-end, this application manage the winner of every giveaway & notification, see orders and products and content of the web. Additionally, payments are efficiently processed through the Mercado Pago API. Here are the key features and details of this application:

## Features

- **User-Friendly Interface:** The dashboard boasts a user-friendly interface built with [boostrap](https://getbootstrap.com/), incorporating pre-made components for quick and easy navigation.

- **Role-Based Authorization:** Users are categorized into different roles, including ADMIN, MODERATOR and USER. Each role is assigned specific authorization levels to ensure secure and controlled access.

- **Insightful Home Panel:** Users can access a comprehensive home panel offering diverse statistical insights into their business operations.

- **Configuration Control:** The application allows flexible configuration of both the Zoom integration and Payment Gateways. Users have complete control over these integrations from within the dashboard.

- **Customizable Access:** While ADMIN and MODERATOR roles have full access to modify information, users  are presented with a simplified view of the dashboard, ensuring a tailored user experience.

- **Automated Email Communication:** Admins can effortlessly create meetings and send notifications through the automated email sender. The feature is also useful for password restoration.

- **Data Analysis:** Meeting data can be downloaded in CSV format, facilitating further analysis by ADMIN or MODERATORS.

- **Billing Convenience:** Users can conveniently download bills in PDF format, serving as payment confirmations for purchased services.


## Dependencies and Libraries

This project relies on the following key dependencies and libraries:

- [Mercado Pago SDK](https://github.com/mercadopago/sdk-php)
- [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)
- [guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle)
- [boostrap](https://getbootstrap.com/)


## Installation and Setup

To install the project on your local machine, you can follow these steps:

1. Clone this repository to your local directory.
2. Install project dependencies using the following command:
```
composer install
```
3. If you have limited server resources, consider installing dependencies locally and exporting the vendor folder using the following command:
```
composer dump-autoload
```
## Screenshots

Here are some screenshots showcasing the dashboard in action:

![Image1](https://github.com/DiegoPevi05/labuelanorma-server/blob/main/public/github/Dashboard_3.png?raw=true)
![Image2](https://github.com/DiegoPevi05/labuelanorma-server/blob/main/public/github/Dashboard_2.png?raw=true)
![Image3](https://github.com/DiegoPevi05/labuelanorma-server/blob/main/public/github/Dashboard_1.png?raw=true)

Thank you for exploring the content of this README.md file. If you have any questions or suggestions, please feel free to reach out!
