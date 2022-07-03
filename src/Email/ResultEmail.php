<?php

namespace App\Email;

use App\Email\ResultEmailInterface;

class ResultEmail {

    private string $email;
    private string $searchTerm;
    private array $data;
    private string $emailHtml;
    public function __construct()
    {
        $this->email        = "";
        $this->searchTerm   = "";
        $this->data         = [];
        $this->emailHtml    = "";
    }

    /**
     * @return string
     */
    public function getEmailHtml(): string
    {
        return $this->emailHtml;
    }

    /**
     * @param string $emailHtml
     */
    public function setEmailHtml(string $emailHtml): void
    {
        $this->emailHtml = $emailHtml;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getSearchTerm(): string
    {
        return $this->searchTerm;
    }

    /**
     * @param string $searchTerm
     */
    public function setSearchTerm(string $searchTerm): void
    {
        $this->searchTerm = $searchTerm;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return ResultEmailInterface
     */
    public function getInterface(): ResultEmailInterface
    {
        return $this->interface;
    }

    /**
     * @param ResultEmailInterface $interface
     */
    public function setInterface(ResultEmailInterface $interface): void
    {
        $this->interface = $interface;
    }

    public function buildResultEmail(ResultEmailInterface $interface): bool {
        $this->setEmailHtml($interface->buildResultEmail($this->data));
        return true;
    }
}
