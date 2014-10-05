<?php

use DanHarper\InboxActions\InboxAction;
use DanHarper\InboxActions\Schemas\PostalAddress;

class RSVPTest extends Test {

    public function testBasicRsvp()
    {
        $actual = InboxAction::RSVP('Taco Night')->start(new DateTime('2015-04-18 15:30'));

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Event",
    "name": "Taco Night",
    "startDate": "2015-04-18T15:30:00+0000"
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testRsvpEndDate()
    {
        $actual = InboxAction::RSVP('Taco Night')->start(new DateTime('2015-04-18 15:30'))->finish(new DateTime('2015-04-18 16:30'));

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Event",
    "name": "Taco Night",
    "startDate": "2015-04-18T15:30:00+0000",
    "endDate": "2015-04-18T16:30:00+0000"
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testRsvpWithDateRange()
    {
        $actual = InboxAction::RSVP('Taco Night')->at(new DateTime('2015-04-18 15:30'), new DateTime('2015-04-18 16:30'));

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Event",
    "name": "Taco Night",
    "startDate": "2015-04-18T15:30:00+0000",
    "endDate": "2015-04-18T16:30:00+0000"
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testRsvpWithProvidedAddress()
    {
        $actual = InboxAction::RSVP('Taco Night')->address(new PostalAddress(
            'Google', '24 Willie Mays Plaza', 'San Francisco', 'CA', '94107', 'USA'
        ));

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Event",
    "name": "Taco Night",
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
    }
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testRsvpWithCallbackForAddress()
    {
        $actual = InboxAction::RSVP('Taco Night')->address(function(PostalAddress $address) {
            $address->name('Google')->street('24 Willie Mays Plaza')->postCode('94107');
        });

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Event",
    "name": "Taco Night",
    "location": {
        "@type": "Place",
        "address": {
            "@type": "PostalAddress",
            "name": "Google",
            "streetAddress": "24 Willie Mays Plaza",
            "postalCode": "94107"
        }
    }
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testRsvpReplies()
    {
        $actual = InboxAction::RSVP('Taco Night')
            ->replyYes('get', 'http://yes')->replyNo('http://no')->replyMaybe('post', 'http://maybe');

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Event",
    "name": "Taco Night",
    "action": [
        {
            "@type": "RsvpAction",
            "attendance": "http://schema.org/RsvpAttendance/Yes",
            "handler": {
                "@type": "HttpActionHandler",
                "method": "http://schema.org/HttpRequestMethod/GET",
                "url": "http://yes"
            }
        },
        {
            "@type": "RsvpAction",
            "attendance": "http://schema.org/RsvpAttendance/No",
            "handler": {
                "@type": "HttpActionHandler",
                "method": "http://schema.org/HttpRequestMethod/GET",
                "url": "http://no"
            }
        },
        {
            "@type": "RsvpAction",
            "attendance": "http://schema.org/RsvpAttendance/Maybe",
            "handler": {
                "@type": "HttpActionHandler",
                "method": "http://schema.org/HttpRequestMethod/POST",
                "url": "http://maybe"
            }
        }
    ]
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testRsvpWithFullExample()
    {
        $actual = InboxAction::RSVP('Taco Night')
            ->at(new DateTime('2015-04-18 15:30'), new DateTime('2015-04-18 16:30'))
            ->address(new PostalAddress('Google', '24 Willie Mays Plaza', 'San Francisco', 'CA', '94107', 'USA'))
            ->replyYes('POST', 'http://foo?y')
            ->replyNo('GET', 'http://xx');

        $expected = <<<OUT
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
                "method": "http://schema.org/HttpRequestMethod/POST",
                "url": "http://foo?y"
            }
        },
        {
            "@type": "RsvpAction",
            "attendance": "http://schema.org/RsvpAttendance/No",
            "handler": {
                "@type": "HttpActionHandler",
                "method": "http://schema.org/HttpRequestMethod/GET",
                "url": "http://xx"
            }
        }
    ]
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

} 