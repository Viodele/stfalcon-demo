<?php declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class Notifier
{
    private const SENDER_EMAIL = 'no-reply@example.com';
    private const SENDER_NAME = 'Notifier';
    private const EMAIL_SUBJECT = 'Currency Rate Changes';

    private array $messages = [];

    public function __construct(
        private readonly MailerInterface $mailer,
        #[Autowire(param: 'serviceNotificationReceiver')]
        private readonly ?string $serviceNotificationReceiver = null
    ) {
    }

    public function push(string $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function flush(): void
    {
        if (true === empty($this->serviceNotificationReceiver)) {
            return;
        }

        $email = (new Email())
            ->from(new Address(self::SENDER_EMAIL, self::SENDER_NAME))
            ->to($this->serviceNotificationReceiver)
            ->subject(self::EMAIL_SUBJECT)
            ->text(implode("\r\n", $this->messages))
            ->html(sprintf(
                '<h3>Exchange Rate Updates</h3><p>%s</p>',
                implode('</p><p>', $this->messages)
            ));

        $this->mailer->send($email);

        $this->messages = [];
    }
}
