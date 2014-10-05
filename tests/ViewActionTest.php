<?php

use DanHarper\InboxActions\InboxAction;

class ViewActionTest extends Test {

    public function testTheMostBasicViewAction()
    {
        $actual = InboxAction::ViewAction('View Report', 'http://acme?report=2');

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "ViewAction",
        "name": "View Report",
        "url": "http://acme?report=2"
    }
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testWithPublisherData()
    {
        $actual = InboxAction::ViewAction('View Report', 'http://acme?report=2')->publisher('Acme', 'http://acme');

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "ViewAction",
        "name": "View Report",
        "url": "http://acme?report=2"
    },
    "publisher": {
        "@type": "Organization",
        "name": "Acme",
        "url": "http://acme"
    }
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testCustomisingNameAndHandler()
    {
        $actual = InboxAction::ViewAction('View Report', 'http://a')->handler('http://b')->named('Report');

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "ViewAction",
        "name": "Report",
        "url": "http://b"
    }
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

}
 