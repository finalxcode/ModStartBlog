## Tech Context

This document details the technologies used in the project, the development setup, technical constraints, and dependencies.

**Technologies Used:**

- **Backend**: Laravel 5.1.* framework with ModStart extension
- **Frontend**: PHP-based templating with existing ModStart UI components
- **Database**: MySQL/PostgreSQL (configured via docker-compose)
- **AI Integration**: taskmaster-ai (v0.16.2) via MCP (Model Control Protocol)
- **Task Management**: taskmaster-ai with Claude, OpenRouter, and other AI provider support
- **Containerization**: Docker with docker-compose orchestration
- **Web Server**: Nginx (configured in nginx.conf)
- **Package Management**: Composer for PHP dependencies, npm for Node.js packages

**Development Setup:**

- **Environment**: Docker-based development environment
- **AI Configuration**: MCP server configured in .cursor/mcp.json and globally
- **Task Management**: .taskmaster directory structure with configs, tasks, docs, and templates
- **Package Installation**: taskmaster-ai installed via npm locally
- The project is deployed using `docker-compose` from the root directory.
- **AI API Keys**: Configured through environment variables or MCP configuration

**Technical Constraints:**

- **PHP Version**: PHP 5.6+ requirement for Laravel 5.1 compatibility
- **Legacy Framework**: Must maintain Laravel 5.1 compatibility (no major upgrades)
- **Container Dependencies**: Node.js integration through docker containers
- **AI API Limits**: Rate limiting and cost considerations for AI service usage

**Dependencies:**

- **Core Framework**: laravel/framework 5.1.*, modstart/modstart-laravel5
- **Content Processing**: league/commonmark, league/commonmark-ext-table
- **AI Integration**: task-master-ai package with MCP protocol support
- **Infrastructure**: Docker, docker-compose, nginx

**Logging:**

- Application logs are stored in the `storage/logs` directory.
- Taskmaster logs and reports stored in `.taskmaster/reports/` 