# Magento 2 Mailchimp Integration — MageMe WebForms

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mageme/module-webforms-3-mailchimp.svg)](https://packagist.org/packages/mageme/module-webforms-3-mailchimp)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mageme/module-webforms-3-mailchimp.svg)](https://packagist.org/packages/mageme/module-webforms-3-mailchimp)
[![License](https://img.shields.io/packagist/l/mageme/module-webforms-3-mailchimp.svg)](https://mageme.com/license/)

Subscribe your Magento 2 customers to Mailchimp audiences through any form. This free add-on for [MageMe WebForms](https://mageme.com/magento-2-form-builder.html) adds Mailchimp subscriber management with merge field mapping, interest groups, and tag support.

## Features

- Add or update Mailchimp audience members from form submissions
- Map form fields to Mailchimp merge fields including multi-part address components
- Let customers choose interest groups via checkboxes, radio buttons, or dropdowns
- Apply tags to subscribers for targeted campaign segmentation
- Support for double opt-in and direct subscription workflows
- Three custom form field types for Mailchimp group selection (checkbox, radio, select)
- Resend submissions to Mailchimp manually from the Magento admin panel

## Requirements

- Magento 2.4.x
- [MageMe WebForms 3](https://mageme.com/magento-2-form-builder.html) version 3.5.0 or higher
- [Mailchimp for Magento 2](https://github.com/mailchimp/mc-magento2) version 103.4.43 or higher

## Installation

```
composer require mageme/module-webforms-3-mailchimp
bin/magento setup:upgrade
bin/magento cache:flush
```

## Configuration

1. Ensure the Mailchimp for Magento 2 module is installed and configured with your API key.
2. Open any form in the admin panel and configure the Mailchimp integration tab — select the target audience, map merge fields, and enable interest groups.

## Other MageMe WebForms Integrations

Capture leads and route them to the right platform:

- [Klaviyo](https://github.com/mageme/module-webforms-3-klaviyo) — build profiles with custom properties and list subscriptions
- [HubSpot](https://github.com/mageme/module-webforms-3-hubspot) — sync contacts, companies, and tickets
- [Salesforce](https://github.com/mageme/module-webforms-3-salesforce) — create leads from form submissions
- [Zoho CRM & Desk](https://github.com/mageme/module-webforms-3-zoho) — create leads and support tickets
- [Freshdesk](https://github.com/mageme/module-webforms-3-freshdesk) — create support tickets automatically
- [Zendesk](https://github.com/mageme/module-webforms-3-zendesk) — create tickets with custom field types
- [Zapier](https://github.com/mageme/module-webforms-3-zapier) — connect forms to 7000+ apps

## About MageMe WebForms

[MageMe WebForms](https://mageme.com/magento-2-form-builder.html) gives Magento 2 merchants a flexible form builder that works out of the box. Build newsletter signup forms, feedback surveys, contact forms, and lead generation forms — with conditional logic, file uploads, and direct integrations with email marketing and CRM platforms.

[Get MageMe WebForms for Magento 2](https://mageme.com/magento-2-form-builder.html)

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Issue Tracker: [GitHub Issues](https://github.com/mageme/module-webforms-3-mailchimp/issues)

## License

Proprietary. See [License](https://mageme.com/license/) for details.
