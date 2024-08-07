<?php

namespace Base\BaseContractsDomain;

interface PatientRecord
{
    public function getId(): int;
    public function getPn(): ?string;

}