<?php

namespace App\Entity\Magento;

use App\Repository\Magento\CronScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CronScheduleRepository::class)]
#[ORM\Table(name: 'cron_schedule')]
#[ORM\Index(columns: ['execution_host'], name: 'CRON_SCHEDULE_EXECUTION_HOST')]
#[ORM\Index(columns: ['job_code', 'status', 'scheduled_at'], name: 'CRON_SCHEDULE_JOB_CODE_STATUS_SCHEDULED_AT')]
#[ORM\Index(columns: ['scheduled_at', 'execution_host', 'status'], name: 'CRON_SCHEDULE_SCHEDULED_AT_EXECUTION_HOST_STATUS')]
class CronSchedule
{
    public const STATUS_RUNNING = 'running';
    public const STATUS_MISSED = 'missed';
    public const STATUS_PENDING = 'pending';
    public const STATUS_ERROR = 'error';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'schedule_id', type: 'integer', options: ['unsigned' => true, 'comment' => 'Schedule ID'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: ['default' => '0', 'comment' => 'Job Code'])]
    private string $jobCode = '0';

    #[ORM\Column(type: Types::STRING, length: 7, options: ['default' => 'pending', 'comment' => 'Status'])]
    private string $status = self::STATUS_PENDING;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => 'Messages'])]
    private ?string $messages = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP', 'comment' => 'Created At'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => 'Scheduled At'])]
    private ?\DateTimeInterface $scheduledAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => 'Executed At'])]
    private ?\DateTimeInterface $executedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => 'Finished At'])]
    private ?\DateTimeInterface $finishedAt = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: ['comment' => 'Execution Host'])]
    private ?string $executionHost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getJobCode(): string
    {
        return $this->jobCode;
    }

    public function setJobCode(string $jobCode): void
    {
        $this->jobCode = $jobCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getMessages(): ?string
    {
        return $this->messages;
    }

    public function setMessages(?string $messages): void
    {
        $this->messages = $messages;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getScheduledAt(): ?\DateTimeInterface
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(?\DateTimeInterface $scheduledAt): void
    {
        $this->scheduledAt = $scheduledAt;
    }

    public function getExecutedAt(): ?\DateTimeInterface
    {
        return $this->executedAt;
    }

    public function setExecutedAt(?\DateTimeInterface $executedAt): void
    {
        $this->executedAt = $executedAt;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeInterface $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    public function getExecutionHost(): ?string
    {
        return $this->executionHost;
    }

    public function setExecutionHost(?string $executionHost): void
    {
        $this->executionHost = $executionHost;
    }
}
