 <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('user_id')->unique();
            $table->string('employee_id')->unique();
			$table->string('father_name', 191)->nullable();
			$table->string('mother_name', 191)->nullable();
			$table->date('dob')->nullable();
			$table->string('street', 191);
			$table->string('state', 80);
			$table->string('zip_code', 20);
			$table->string('country', 80);
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->date('joining_date');
            $table->date('exit_date')->nullable();
            $table->decimal('joining_salary',8,2);
            $table->decimal('current_salary',8,2);
            $table->string('account_holder_name', 191)->nullable();
            $table->string('account_number', 80)->nullable();
            $table->string('bank_name', 191)->nullable();
            $table->string('bank_identifier_code', 100)->nullable();
            $table->string('branch_location', 100)->nullable();
            $table->string('resume', 191)->nullable();
            $table->string('joining_letter', 191)->nullable();
            $table->string('id_card', 191)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
