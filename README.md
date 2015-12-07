# Inbox Actions

A small library to generate Schema.org markup to embed in emails to achieve ["Actions in Inbox"](https://developers.google.com/gmail/actions/).

```
composer require danharper/inbox-actions
```

## Usage

So far, the following "Actions" from Gmail are supported:

* [View](#view)
* [RSVP](#rsvp)
* [Confirm / Save](#confirm--save)

### View

```php
<?php
use DanHarper\InboxActions\InboxAction;

$action = InboxAction::ViewAction('View Report', 'http://example');

echo $action;
```

Outputs:

```html
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "ViewAction",
        "name": "View Report",
        "url": "http://example"
    }
}
</script>
```

![](http://danharper.me/inbox-actions/view-action.png)

You can also add in details of your Organization:

```php
<?php

InboxAction::ViewAction('ViewReport', 'http://example')
	->publisher('Acme', 'http://acme');
```

```html
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "ViewAction",
        "name": "View Report",
        "url": "http://example"
    },
    "publisher": {
        "@type": "Organization",
        "name": "Acme",
        "url": "http://acme"
    }
}
</script>
```

### RSVP

```php
<?php
use DanHarper\InboxActions\InboxAction;
use DanHarper\InboxActions\Schemas\PostalAddress;

InboxAction::RSVP('Taco Night')
	->at(new DateTime('2015-04-18 15:30'), new DateTime('2015-04-18 16:30'))
	->address(new PostalAddress(
		'Google', '24 Willie Mays Plaza', 'San Francisco', 'CA', '94107', 'USA'
	))
	->yes('http://acme')
	->no('http://acme')
	->maybe('http://acme');
```

When `echo`'d, results in:

```html
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Event",
    "name": "Taco Night",
    "startDate": "2015-04-18T15:30:00+0000",
    "endDate": "2015-04-18T16:30:00+0000",
    "location": {
        "@type": "Place",
        "address": {
            "@type": "PostalAddress",
            "name": "Google",
            "streetAddress": "24 Willie Mays Plaza",
            "addressLocality": "San Francisco",
            "addressRegion": "CA",
            "postalCode": "94107",
            "addressCountry": "USA"
        }
    },
    "action": [
        {
            "@type": "RsvpAction",
            "attendance": "http://schema.org/RsvpAttendance/Yes",
            "handler": {
                "@type": "HttpActionHandler",
                "method": "http://schema.org/HttpRequestMethod/GET",
                "url": "http://acme"
            }
        },
        {
            "@type": "RsvpAction",
            "attendance": "http://schema.org/RsvpAttendance/No",
            "handler": {
                "@type": "HttpActionHandler",
                "method": "http://schema.org/HttpRequestMethod/GET",
                "url": "http://acme"
            }
        },
        {
            "@type": "RsvpAction",
            "attendance": "http://schema.org/RsvpAttendance/Maybe",
            "handler": {
                "@type": "HttpActionHandler",
                "method": "http://schema.org/HttpRequestMethod/GET",
                "url": "http://acme"
            }
        }
    ]
}
</script>
```

There's multiple ways you can define the event dates, the address and the possible responses:

```php
<?php
InboxAction::RSVP('Taco Night')

	// you can define a date range with "at"
	->at(new DateTime('2015-04-18 15:30'), new DateTime('2015-04-18 16:30'))
	// OR you can define the dates separately
	->start(new DateTime('2015-04-18 15:30'))
	->finish(new DateTime('2015-04-18 16:30'))
	// you MUST define at least a start date
	
	// you can specify the address by providing an Address object:
	->address(new PostalAddress(
		'Google', '24 Willie Mays Plaza', 'San Francisco', 'CA', '94107', 'USA'
	))
	// OR with a callback where the address is given to you:
	->address(function(PostalAddress $adr) {
		// you can skip any of these fields
		$adr->name('Google')
			->street('24 Willie Mays Plaza')
			->city('San Francisco')
			->region('CA')
			->postCode('94107')
			->country('USA');
	})
	
	// you MUST specify both "yes" and "no" response URLs
	->yes('http://acme?response=yes')
	->no('http://acme?response=no')
	
	// you MAY specify a "maybe" response URL
	->maybe('http://acme?response=maybe')
	
	// by default, responses will be GET requests
	// you can be explicit, or use a POST request instead:
	->yes('http://acme', 'GET')
	->yes('http://acme', 'POST');
```

![](http://danharper.me/inbox-actions/rsvp.png)
![](http://danharper.me/inbox-actions/rsvp-inline.png)
![](http://danharper.me/inbox-actions/rsvp-inbox.png)

### Confirm / Save

Confirm actions and save actions are near-enough identical. You can swap out `ConfirmAction` with `SaveAction` below for semantics.

```php
<?php
use DanHarper\InboxActions\InboxAction;

InboxAction::ConfirmAction('Approve Expense', 'http://acme.com');

// Also supports publisher details
InboxAction::ConfirmAction('Approve Expense', 'http://acme.com')
	->publisher('Acme', 'http://acme');

// Use POST for URL handler
InboxAction::ConfirmAction('Approve Expense')->handler('http://acme.com', 'POST');

// Require additional confirmation from user after clicking button
InboxAction::ConfirmAction('Approve Expense', 'http://acme')
	->requireConfirmation();
```

Example output:

```html
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "ConfirmAction",
        "name": "Approve Expense",
        "handler": {
            "@type": "HttpActionHandler",
            "method": "http://schema.org/HttpRequestMethod/GET",
            "url": "http://acme.com/?approve=29394&auth=28usj92k",
            "requiresConfirmation": true
        }
    },
    "publisher": {
        "@type": "Organization",
        "name": "Acme Incorporated",
        "url": "http://acme.org"
    }
}
</script>
```


