# PowerIO - Solar Panel Quotation System

A Laravel 12 + Filament 4 application for managing solar panel installation projects and generating professional quotations with AI-powered sunshine hour predictions.

## Overview

PowerIO is a comprehensive solution for solar energy companies to manage customer projects, calculate optimal solar panel configurations, and generate detailed quotations. The application leverages clean code principles, SOLID design patterns, and modern Laravel features to provide a maintainable and extensible codebase.

## Tech Stack

- **Framework**: Laravel 12.0
- **Admin Panel**: Filament 4.0
- **PHP**: 8.2+
- **AI Integration**: OpenAI PHP Laravel
- **PDF Generation**: DOMPDF
- **Testing**: Pest

## Key Features

- Customer and project management
- Solar panel catalog with specifications
- AI-powered sunshine hour generation based on location
- Flexible quotation generation with multiple calculation strategies
- PDF export and email delivery
- Optional add-ons management
- Clean, intuitive admin interface powered by Filament

## Architecture & Design Patterns

This project demonstrates professional software engineering practices using multiple design patterns and SOLID principles:

### 1. Strategy Pattern

The core calculation engine uses the **Strategy Pattern** to provide flexible solar panel optimization algorithms.

**Abstract Base Class**: `app/Contracts/SolarPanelCalculatorStrategy.php`

```php
abstract class SolarPanelCalculatorStrategy
{
    public const LOSS_FACTOR = 0.8;
    public const POWER_MARGIN = 100;

    public function calculate(Project $project): SolarPanelCalculationDTO {
        $peakPower = $this->computePeakPower($project);
        return $this->generateSolarPanelCalculation($project, $peakPower);
    }

    abstract protected function generateSolarPanelCalculation(
        Project $project,
        float $peakPower
    ): ?SolarPanelCalculationDTO;
}
```

**Concrete Implementations**:

1. **SolarPanelCalculatorOneTypeStrategy** (`app/Services/SolarPanel/SolarPanelCalculatorOneTypeStrategy.php`)
   - Selects a single panel type that best matches the power requirements
   - Minimizes excess power generation
   - Ideal for uniform installations

2. **SolarPanelCalculatorMultiTypeStrategy** (`app/Services/SolarPanel/SolarPanelCalculatorMultiTypeStrategy.php`)
   - Combines multiple panel types for optimal coverage
   - Uses greedy algorithm to minimize cost
   - Provides flexibility for complex installations

### 2. Data Transfer Objects (DTOs)

DTOs ensure type-safe data transfer between layers:

**Key DTOs**:
- `SolarPanelCalculationDTO`: Contains calculation results with utility methods
- `SolarPanelItemDTO`: Represents individual panel items with auto-calculated totals
- `SunshineHoursDTO`: AI-generated sunshine hour data
- `QuotationTotals`: Immutable quotation totals

```php
// app/DTO/SolarPanelItemDTO.php
readonly class SolarPanelItemDTO
{
    public float $totalCost;

    private function __construct(
        public SolarPanel $solarPanel,
        public int $numberOfPanels
    ) {
        $this->totalCost = $this->solarPanel->price * $this->numberOfPanels;
    }

    public static function create(SolarPanel $solarPanel, int $numberOfPanels): self
    {
        return new self($solarPanel, $numberOfPanels);
    }
}
```

**Benefits**:
- Immutable data structures (readonly properties)
- Type safety throughout the application
- Factory methods for controlled instantiation
- No logic leakage into models

### 3. Dependency Injection

All services use constructor injection for dependencies:

```php
// app/Services/Quotation/QuotationGeneratorService.php
class QuotationGeneratorService
{
    public function __construct(
        private QuotationSolarPanelService $solarPanelService,
        private QuotationOptionService $optionService,
        private QuotationTotalCalculator $totalCalculator
    ) {}
}
```

Bindings are configured in `AppServiceProvider`:

```php
$this->app->bind(AgentIAInterface::class, function ($app) {
    $model = config('services.openai.model', 'gpt-4o');
    return new OpenAIAgent($model);
});
```

### 4. Dependency inversion

Contracts define behavior without implementation details:

```php
// app/Contracts/AgentIAInterface.php
interface AgentIAInterface
{
    public function sendMessage(string $message, array $context = []): string;

    public function sendMessageWithJsonOutput(
        string $message,
        array $jsonSchema = []
    ): array;

    public function getAgentName(): string;
}
```
## Installation

```bash
# Clone the repository
git clone <repository-url>
cd powerio

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database and OpenAI settings in .env
# DB_CONNECTION=mysql
# OPENAI_API_KEY=your-api-key

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Start development server
php artisan serve
```

## Configuration

### OpenAI Configuration

Add to `.env`:
```env
OPENAI_API_KEY=your-api-key-here
OPENAI_MODEL=gpt-4o-mini
```

### Email Configuration

Configure mail settings in `.env` for quotation delivery:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@powerio.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Testing

```bash
# Run all tests
php artisan test
```
## License

This project is proprietary software. All rights reserved.

## Credits

Built with:
- [Laravel](https://laravel.com)
- [Filament](https://filamentphp.com)
- [OpenAI PHP Laravel](https://github.com/openai-php/laravel)
