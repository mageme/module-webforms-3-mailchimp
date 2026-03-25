# MageMe WebForms 3 — Mailchimp Integration

Free add-on for [MageMe WebForms for Magento 2](https://mageme.com/magento-2-form-builder.html) that integrates form submissions with Mailchimp.

## Features

- Subscribe form respondents to Mailchimp audiences
- Support for interest groups (checkboxes, radio buttons, dropdowns)
- Map form fields to Mailchimp merge fields including address components

## Requirements

- Magento 2.4.x
- [MageMe WebForms 3](https://mageme.com/magento-2-form-builder.html) version 3.5.0 or higher
- [Mailchimp for Magento 2](https://github.com/mailchimp/mc-magento2) version 103.4.43 or higher

## Installation

### Via Composer

```
composer require mageme/module-webforms-3-mailchimp
bin/magento setup:upgrade
bin/magento cache:flush
```

### Manual Installation

1. Download and extract to `app/code/MageMe/WebFormsMailchimp/`
2. Run `bin/magento setup:upgrade`
3. Run `bin/magento cache:flush`

## Configuration

1. Make sure the Mailchimp for Magento 2 module is installed and configured with your Mailchimp API key.
2. Open a form in the admin panel and configure the Mailchimp integration tab to select the target audience and map form fields.

## About MageMe WebForms

[MageMe WebForms](https://mageme.com/magento-2-form-builder.html) is a powerful form builder for Magento 2 that allows you to create any type of form — contact forms, surveys, registration forms, order forms, and more — with a drag-and-drop interface, conditional logic, file uploads, and CRM integrations.

[Get MageMe WebForms](https://mageme.com/magento-2-form-builder.html)

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Issue Tracker: [GitHub Issues](https://github.com/mageme/module-webforms-3-mailchimp/issues)

## License

Proprietary. See [License](https://mageme.com/license/) for details.
