# mmi-cms-event-publisher

A PHP library for publishing CMS category events to message queues (AMQP/RabbitMQ) or in-memory storage. Part of the MMi CMS ecosystem.

## Quick Start

```bash
git clone <repository-url> mmi-cms-event-publisher
cd mmi-cms-event-publisher
composer install
composer test:all
```

## Requirements

- PHP 8.4+
- Composer
- ext-amqp (for RabbitMQ support)

## Development Setup

### Install Dependencies

```bash
composer install
```

### Run Tests

```bash
# Run PHPUnit tests
composer test:phpunit

# Run all quality checks (security, phpcs, phpstan, phpmd, phpunit)
composer test:all
```

### Code Quality

```bash
# Static analysis
composer test:phpstan

# Code style check
composer test:phpcs

# Mess detection
composer test:phpmd

# Auto-fix code style issues
composer fix:all
```

## Architecture

### Core Components

**Messages** - Represent CMS category operations:
- `MessageInterface` - Contract for all messages
- `AbstractCategoryMessage` - Base class handling JSON serialization
- `UpdateCategoryMessage` - Category update events
- `DeleteCategoryMessage` - Category delete events

**Publishers** - Handle message delivery:
- `MessagePublisherInterface` - Publisher contract
- `InMemoryMessagePublisher` - In-memory storage (testing/dev)
- `AmqpMessagePublisher` - RabbitMQ publisher (production)

### Design Pattern

The library uses the Strategy pattern with interface-based design. The DI container automatically selects the appropriate publisher based on configuration.

```
MessageInterface ← AbstractCategoryMessage ← Update/DeleteCategoryMessage
MessagePublisherInterface ← InMemoryMessagePublisher | AmqpMessagePublisher
```

## Configuration

Environment variables control publisher behavior:

| Variable | Default | Description |
|----------|---------|-------------|
| `CMS_PUBLISHER_QUEUE_ENABLED` | `false` | Enable RabbitMQ publishing |
| `CMS_PUBLISHER_QUEUE_HOST` | `localhost` | RabbitMQ host |
| `CMS_PUBLISHER_QUEUE_PORT` | `5672` | RabbitMQ port |
| `CMS_PUBLISHER_QUEUE_VHOST` | `cms` | RabbitMQ virtual host |
| `CMS_PUBLISHER_QUEUE_USERNAME` | `''` | RabbitMQ username |
| `CMS_PUBLISHER_QUEUE_PASSWORD` | `''` | RabbitMQ password |
| `CMS_PUBLISHER_QUEUE_EXCHANGE` | `cms.content.updates` | Exchange name |

## Usage

### Basic Integration

```php
// Include DI configuration in your container setup
// di.publisher.php handles publisher selection automatically

// Inject MessagePublisherInterface where needed
$publisher = $container->get(MessagePublisherInterface::class);

// Create and publish messages
$message = new UpdateCategoryMessage($categoryRecord);
$publisher->publish($message);
```

### Testing

Use `InMemoryMessagePublisher` directly for unit tests:

```php
$publisher = new InMemoryMessagePublisher();
$publisher->publish(new UpdateCategoryMessage($category));

$messages = $publisher->getMessages(); // Access published messages
```

## Project Structure

```
src/CmsEventPublisher/
├── AbstractCategoryMessage.php    # Base message class
├── AmqpMessagePublisher.php       # RabbitMQ implementation
├── DeleteCategoryMessage.php      # Delete event
├── di.publisher.php               # DI configuration
├── InMemoryMessagePublisher.php   # In-memory implementation
├── MessageInterface.php           # Message contract
├── MessagePublisherInterface.php  # Publisher contract
└── UpdateCategoryMessage.php      # Update event

tests/
├── Mock/                          # Test mocks
└── Unit/                          # Unit tests
```

## Docker

Build development container:

```bash
docker build --build-arg PHP_VERSION=8.4 -t mmi-cms-event-publisher .
```

## CI/CD

GitHub Actions runs on PRs and pushes:
- Tests against PHP 8.4 and 8.5
- Runs full quality suite (phpcs, phpstan, phpmd, phpunit)
- Builds Docker image

## Code Standards

- **Coding:** PSR-2
- **Static Analysis:** PHPStan Level 8
- **Mess Detection:** PHPMD (Clean Code, Design, Unused Code)
- **License:** MIT
