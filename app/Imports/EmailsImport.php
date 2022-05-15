<?php

namespace App\Imports;

use App\Models\Newsletter;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmailsImport implements 
    ToModel, 
    WithStartRow, 
    SkipsOnError, 
    WithHeadingRow, 
    WithCustomCsvSettings, 
    WithValidation,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    private $lista;

    public function __construct(int $lista) 
    {
        $this->lista = $lista;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // foreach($data as $row) {
        //     $data = Newsletter::find($row['email']);
        //     if (empty($data)) {
        //         return new Newsletter([
        //             'nome'     => $row['nome'],
        //             'email'    => $row['email'],
        //             'categoria' => $this->lista,
        //         ]);
        //     } 
        // }
        $email = Newsletter::create([
            'nome'     => $row['nome'],
            'email'    => $row['email'],
            'categoria' => $this->lista,
        ]);

        return $email;

        $email->assignRole('guest');
    }

    public function rules(): array
    {
        $id = $this->lista;

        return [
            '*.email' => ['email', 'unique:newsletter,email,']//"unique:newsletter,email,{$id},categoria"
        ];
    }

    public function customValidationMessages()
    {
        return [
            'email.unique' => 'Existem emails já cadastrados.',
        ];
    }

    // public function onFailure(Failure ...$failures)
    // {
        
    // }
}