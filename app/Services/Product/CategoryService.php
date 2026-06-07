<?php

namespace App\Services\Product;

interface CategoryService
{
    public function getAll();
    public function getCompanies();
    public function getCategoriesByCompany($company_id);
}