The project aims to develop a system that calculates the popularity of a given word by searching GitHub issues. The system will utilize the GitHub API to retrieve search results for the specified word and analyze them to determine the popularity rating.

Explanation for the software architecture:

The project follows the SOLID principle, which promotes good software design and maintainability. The codebase is structured using a Service architecture, which separates concerns and promotes single responsibility. Each service class focuses on a specific task, such as searching for issues, calculating scores, or interacting with the database. This design allows for easier maintenance and extensibility, as each service class can be modified or replaced independently without affecting other parts of the system.

The project also adheres to the DRY (Don't Repeat Yourself) principle. Code duplication is minimized by utilizing reusable components such as service classes and helper functions. For example, the search functionality is encapsulated in the SocialMediaSearchManager, which can be used by both V1 and V2 controllers to perform the search operation. This approach eliminates the need to duplicate the search logic in multiple places, promoting code reuse and reducing the chances of introducing errors.

Flexibility in Score Providers:
The project is designed to easily accommodate different score providers. Currently, the system uses GitHub as the score provider, but it can be extended to support other platforms such as Twitter. This flexibility is achieved through the use of service classes and dependency injection. By abstracting the score provider functionality into separate classes and injecting them into the controllers, it becomes straightforward to swap out the score provider implementation. Adding a new score provider would involve creating a new service class that implements the required interface or extends a base class and configuring the dependency injection container to use the new implementation.

API Documentation:
The project includes API documentation in the form of a separate web page on the link: `/docs#endpoints`. This page provides comprehensive instructions on how to interact with the API, including the available endpoints, query parameters, and the expected response format. It also includes practical examples to illustrate the API usage, making it easier for developers to understand and utilize the system. By providing clear and concise documentation, the project promotes good developer experience and facilitates future development and maintenance.

Versioning and JSON API Design:
The project demonstrates versioning of API endpoints. It includes a V1 controller, which represents a classic endpoint design, and a V2 controller that adheres to the JSON API specification. This demonstrates the project's capability to handle different versions of the API and adapt to evolving requirements. The JSON API design follows the guidelines provided in the documentation, ensuring compliance with industry standards and best practices.

Unit Testing:
The project emphasizes unit testing to ensure the reliability and correctness of the codebase. Both service classes and controllers are unit tested, covering critical functionality and edge cases. By writing unit tests, the project achieves better test coverage, identifies and resolves bugs early in the development process, and provides confidence in the system's behavior. The unit tests serve as living documentation, showcasing the expected behavior of the code and making it easier for future developers to understand and modify the project.

In summary, the project incorporates SOLID and DRY principles, follows a service architecture, and allows for easy integration of different score providers. It includes comprehensive API documentation, demonstrates versioning and JSON API design, and prioritizes unit testing for robustness and maintainability.

`Note:` I want to highlight that due to time constraints, I was unable to write tests for API responses and implement a CI/CD (Continuous Integration/Continuous Deployment) pipeline for the project. I take full responsibility for this and acknowledge that these are important aspects of a production-ready application. However, I understand the significance of these practices and I am committed to implementing them in future iterations of the project. Thank you for your understanding.

- Installation
  - Clone project from GitHub
  - Run command: `sail up -d` (Docker image from Laravel community)
  - Run : `sail composer install`
  - Run: `sail artisan migrate`
  - API routes are explained in documentation here: http://localhost/docs#endpoints
    - examples: 
      - http://localhost/api/V1/search?term=good
      - http://localhost/api/V2/search?term=good
  - And you ready to start.
