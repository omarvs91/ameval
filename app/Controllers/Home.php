<?php

namespace App\Controllers;

include(APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;

class Home extends BaseController
{
    private function _getDbData()
    {
        $db = (new \Config\Database())->default;
        return [
            'adapter' => [
                'driver' => 'Pdo_Mysql',
                'host' => $db['hostname'],
                'database' => $db['database'],
                'username' => $db['username'],
                'password' => $db['password'],
                'charset' => 'utf8'
            ]
        ];
    }
    private function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true)
    {
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();

        $groceryCrud = new GroceryCrud($config, $db);

        $groceryCrud->setCsrfTokenName(csrf_token());
        $groceryCrud->setCsrfTokenValue(csrf_hash());

        return $groceryCrud;
    }
    private function _mainOutput($output = null)
    {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        return view('output', (array) $output);
    }
    public function index()
    {
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'output' => view('main')
        ];
        return $this->_mainOutput($output);
    }
    public function op()
    {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('op');
        $crud->defaultOrdering('op.id', 'desc');

        $crud->setSkin('dark');
        $crud->setSubject('OP');

        $crud->setRelation('cliente_id', 'clientes', 'nombres');

        $crud->setRelation('estado_op_id', 'estados_op', 'nom_estado_op');

        $crud->setRelation('registered_by_user_id', 'users', 'username');

        $crud->setRelation('last_updated_by_user_id', 'users', 'username');

        $crud->fieldType('tipo_comprobante', 'dropdown_search', [
            "B" => "BOLETA",
            "F" => "FACTURA"
        ]);

        $crud->fieldType('tipo', 'dropdown_search', [
            "S" => "SERVICIO",
            "F" => "FABRICACION"
        ]);

        $crud->fieldType('estado_pago', 'dropdown_search', [
            "P" => "PARCIALMENTE PAGADO",
            "T" => "TOTALMENTE PAGADO"
        ]);

        $crud->columns(['cod_op', 'cod_comprobante', 'estado_op_id', 'abonado', 'costo_total']);

        $crud->readFields(['cod_op', 'cod_comprobante', 'cliente_id', 'descripcion', 'estado_op_id', 'abonado', 'costo_total', 'registered_by_user_id', 'last_updated_by_user_id', 'fecha_creacion', 'fecha_actualizacion', 'observacion']);

        $crud->addFields(['cliente_id', 'tipo', 'tipo_comprobante', 'descripcion', 'estado_pago', 'costo_total', 'abonado', 'observacion']);

        $crud->editFields(['descripcion', 'estado_op_id', 'fecha_inicio', 'fecha_entrega', 'observacion']);

        $crud->displayAs([
            'cod_op' => 'OP',
            'descripcion' => 'DESCRIPCION',
            'fecha_creacion' => 'CREADO EN',
            'fecha_actualizacion' => 'ACTUALIZADO EN',
            'observacion' => 'OBSERVACIÓN',
            'tipo_comprobante' => 'TIPO DE COMPROBANTE',
            'cod_comprobante' => 'COMPROBANTE',
            'cliente_id' => 'CLIENTE',
            'registered_by_user_id' => 'REGISTRADO POR',
            'last_updated_by_user_id' => 'ÚLTIMA ACTUALIZACIÓN POR',
            'costo_total' => 'COSTO TOTAL (S/.)',
            'abonado' => 'ABONADO (S/.)',
            'estado_op_id' => 'ESTADO',
            'tipo' => 'SERVICIO / FABRICACION',
            'estado_pago' => 'ESTADO DE PAGO',
            'fecha_inicio' => 'FECHA DE INICIO',
            'fecha_entrega' => 'FECHA DE ENTREGA'
        ]);

        $crud->setTexteditor(['descripcion']);

        $crud->unsetFilters();

        $crud->setRead();

        $crud->setActionButton('Editar Mano de Obra', 'fa fa-user', function ($row) {
            return '/op_mano_obra/' . $row->id;
        }, false);

        $crud->setActionButton('Editar Materiales', 'fa-solid fa-toolbox', function ($row) {
            return '/op_materiales/' . $row->id;
        }, false);

        $crud->setActionButton('Editar Costos Indirectos', 'fa-solid fa-hand-holding-dollar', function ($row) {
            return '/op_gastos_indirectos/' . $row->id;
        }, false);

        $crud->callbackAfterInsert(function ($stateParameters) {
            $id = $stateParameters->insertId;
            $tipo_comprobante = $stateParameters->data['tipo_comprobante'];

            // Load the ComprobanteCounter model
            $comprobanteCounterModel = new \App\Models\ComprobanteCounter();

            // Get the last_value for the tipo_comprobante
            $comprobanteCounter = $comprobanteCounterModel->where('tipo_comprobante', $tipo_comprobante)->first();

            // If this tipo_comprobante is not in the comprobante_counter table yet, initialize it
            if ($comprobanteCounter === null) {
                $comprobanteCounterModel->insert(['tipo_comprobante' => $tipo_comprobante, 'last_value' => 1]);
                $last_value = 1;
            } else {
                $last_value = $comprobanteCounter['last_value'] + 1;
                $comprobanteCounterModel->update($tipo_comprobante, ['last_value' => $last_value]);
            }

            // Generate the cod_comprobante
            $prefix = '';
            switch ($tipo_comprobante) {
                case 'B':
                    $prefix = 'B';
                    break;
                case 'F':
                    $prefix = 'F';
                    break;
            }
            $cod_comprobante = $prefix . '001-' . $last_value;
            $cod_op = '0' . $id;

            // Load the Op model
            $opModel = new \App\Models\Op();

            // Update the op record
            $opModel->update($id, [
                'cod_comprobante' => $cod_comprobante,
                'cod_op' => $cod_op,
                'registered_by_user_id' => session()->get('user_id'),
                'last_updated_by_user_id' => session()->get('user_id')
            ]);


            return $stateParameters;
        });

        $crud->callbackBeforeUpdate(function ($stateParameters) {
            $stateParameters->data['last_updated_by_user_id'] = session()->get('user_id');
            return $stateParameters;
        });

        $crud->setLangString('insert_success_message', 'SE REGISTRO OP');

        // Render the CRUD
        $output = $crud->render();
        return $this->_mainOutput($output);
    }
    public function op_mano_obra()
    {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('op_mano_obra');
        $crud->setSkin('dark');
        $crud->setSubject('MANO DE OBRA');
        $crud->setRelation('op_id', 'op', 'cod_op');
        $crud->setRelation('empleado_id', 'empleados', 'nom_empleado');
        $crud->unsetPrint();
        $crud->unsetExport();
        $crud->displayAs([
            'op_id' => 'CÓDIGO DE OP',
            'empleado_id' => 'TIPO DE EMPLEADO',
            'horas_trabajadas' => 'HORAS HOMBRE',
            'cantidad' => 'CANTIDAD DE PERSONAL',
            'valor_x_hora' => 'VALOR POR HORA',            
            'total' => 'TOTAL',
            'comprobante' => 'COMPROBANTE'
        ]);
        $crud->columns(['comprobante','empleado_id', 'horas_trabajadas', 'valor_x_hora', 'cantidad', 'total']);

        $crud->fieldTypeColumn('comprobante', 'varchar');

        $crud->mapColumn('comprobante', 'op_id');

        $db = \Config\Database::connect();

        $crud->callbackColumn('comprobante', function ($value, $row) use ($db) {            
            $q = $db->query("SELECT cod_comprobante FROM op WHERE id = ?", $value);
            $a = $q->getRowArray();
            $cod_comprobante = $a['cod_comprobante'];
            return $cod_comprobante;
        });

        $crud->addFields(['empleado_id', 'cantidad', 'horas_trabajadas']);
        $crud->editFields(['empleado_id', 'cantidad', 'horas_trabajadas']);

        // Get the URL path and explode it to extract segments
        $uri = service('uri');
        $path = $uri->getPath();
        $segments = explode('/', $path);

        // Find the index of "op_mano_obra" in segments array
        $op_mano_obra_index = array_search('op_mano_obra', $segments);

        // Extract the segment after "op_mano_obra"
        $segment = $segments[$op_mano_obra_index + 1] ?? null;

        $crud->where([
            'op_mano_obra.op_id' => $segment
        ]);

        $db = \Config\Database::connect();

        $crud->callbackAfterInsert(function ($stateParameters) use ($db) {
            // Extract necessary data from $stateParameters
            $id = $stateParameters->insertId;
            $empleado_id = $stateParameters->data['empleado_id'];

            // Retrieve employee's value per hour from the database
            $q = $db->query("SELECT valor_x_hora FROM empleados WHERE id = ?", $empleado_id);
            $tbl_empleados = $q->getRowArray();
            $valor_x_hora = $tbl_empleados['valor_x_hora'];

            // Calculate total based on hours worked and value per hour
            $total = $valor_x_hora * $stateParameters->data['horas_trabajadas'] * $stateParameters->data['cantidad'];
            $formattedTotal = number_format($total, 2, '.', '');

            // Get the URL path and explode it to extract segments
            $uri = service('uri');
            $path = $uri->getPath();
            $segments = explode('/', $path);

            // Find the index of "op_mano_obra" in segments array
            $op_mano_obra_index = array_search('op_mano_obra', $segments);

            // Extract the segment after "op_mano_obra"
            $segment = $segments[$op_mano_obra_index + 1] ?? null;

            // If a valid segment is found, update the database
            if ($segment !== null && is_numeric($segment)) {
                $db->query("UPDATE op_mano_obra SET op_id = ?, valor_x_hora = ?, total = ? WHERE id = ?", [$segment, $valor_x_hora, $formattedTotal, $id]);
            }

            return $stateParameters;
        });

        $crud->callbackBeforeUpdate(function ($stateParameters) use ($db) {

            // Retrieve employee's value per hour from the database
            $q = $db->query("SELECT valor_x_hora FROM empleados WHERE id = ?", $stateParameters->data['empleado_id']);
            $tbl_empleados = $q->getRowArray();
            $valor_x_hora = $tbl_empleados['valor_x_hora'];
            $total = $valor_x_hora * $stateParameters->data['horas_trabajadas'] * $stateParameters->data['cantidad'];
            $stateParameters->data['total'] = number_format($total, 2, '.', '');
        
            return $stateParameters;
        });

        // Render the CRUD
        $output = $crud->render();
        
        /*$js_files = $output->js_files;
        $output = $output->output;
        $title = 'OP 0' . $uri->getSegment(2) . ': MANO DE OBRA';

        return $this->_mainOutput(['output' => $output, 'title' => $title, 'js_files' => $js_files]);*/

        return $this->_mainOutput($output);
    }
    public function materiales()
    {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('op_materiales');
        $crud->setSkin('dark');
        $crud->setSubject('MATERIAL');
        $crud->displayAs([
            'material' => 'MATERIAL',
            'precio_unitario' => 'PRECIO UNITARIO (S/.)',
            'cantidad' => 'CANTIDAD',
            'precio_uni' => 'PRECIO UNITARIO',
            'total' => 'TOTAL',
            'op_id' => 'OP',
            'comprobante' => 'COMPROBANTE'
        ]);

        $crud->columns(['comprobante', 'material', 'cantidad', 'precio_uni', 'total']);

        $crud->fieldTypeColumn('comprobante', 'varchar');

        $crud->mapColumn('comprobante', 'op_id');

        $db = \Config\Database::connect();

        $crud->callbackColumn('comprobante', function ($value, $row) use ($db) {            
            $q = $db->query("SELECT cod_comprobante FROM op WHERE id = ?", $value);
            $a = $q->getRowArray();
            $cod_comprobante = $a['cod_comprobante'];
            return $cod_comprobante;
        });

        // Get the URL path and explode it to extract segments
        $uri = service('uri');
        $path = $uri->getPath();
        $segments = explode('/', $path);

        // Find the index of "op_gastos_indirectos" in segments array
        $op_materiales_index = array_search('op_materiales', $segments);

        // Extract the segment after "op_mano_obra"
        $segment = $segments[$op_materiales_index + 1] ?? null;

        $crud->where([
            'op_materiales.op_id' => $segment
        ]);

        // Render the CRUD
        $output = $crud->render();
        return $this->_mainOutput($output);
    }
    public function gastos_indirectos()
    {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('op_gastos_indirectos');
        $crud->setSkin('dark');
        $crud->setSubject('GASTO INDIRECTO');
        $crud->displayAs([
            'gasto_indirecto' => 'GASTO INDIRECTO',
            'horas_trabajadas' => 'HORAS USADAS',
            'valor_x_hora' => 'PRECIO POR HORA (S/.)',
            'op_id' => 'OP',
            'total' => 'TOTAL',
            'comprobante' => 'COMPROBANTE'
        ]);

        $crud->columns(['comprobante', 'gasto_indirecto','horas_trabajadas', 'valor_x_hora', 'total']);

        $crud->fieldTypeColumn('comprobante', 'varchar');

        $crud->mapColumn('comprobante', 'op_id');

        $db = \Config\Database::connect();

        $crud->callbackColumn('comprobante', function ($value, $row) use ($db) {            
            $q = $db->query("SELECT cod_comprobante FROM op WHERE id = ?", $value);
            $a = $q->getRowArray();
            $cod_comprobante = $a['cod_comprobante'];
            return $cod_comprobante;
        });

        $crud->addFields(['gasto_indirecto','horas_trabajadas','valor_x_hora']);

        $crud->fieldType('valor_x_hora', 'float');

        // Get the URL path and explode it to extract segments
        $uri = service('uri');
        $path = $uri->getPath();
        $segments = explode('/', $path);

        // Find the index of "op_gastos_indirectos" in segments array
        $op_gastos_indirectos_index = array_search('op_gastos_indirectos', $segments);

        // Extract the segment after "op_mano_obra"
        $segment = $segments[$op_gastos_indirectos_index + 1] ?? null;

        $crud->where([
            'op_gastos_indirectos.op_id' => $segment
        ]);

        // Render the CRUD
        $output = $crud->render();
        return $this->_mainOutput($output);
    }
    public function estados()
    {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('estados_op');
        $crud->setSkin('dark');
        $crud->setSubject('ESTADO DE OP');
        $crud->displayAs([
            'nom_estado_op' => 'ESTADO DE OP',
        ]);

        // Render the CRUD
        $output = $crud->render();
        return $this->_mainOutput($output);
    }
    public function getLastCodComprobante()
    {
        // Perform necessary database query to get the last cod_comprobante
        // Example query (modify this according to your database schema)
        $db = \Config\Database::connect(); // Assuming you use CodeIgniter 4
        $query = $db->query("SELECT cod_comprobante FROM op ORDER BY id DESC LIMIT 1");
        $result = $query->getRow();

        if ($result) {
            return $result->cod_comprobante;
        }

        return null; // If no cod_comprobante is found
    }
    public function clientes()
    {
        $crud = $this->_getGroceryCrudEnterprise();

        $crud->setTable('clientes');
        $crud->setSkin('dark');
        $crud->setRead();
        $crud->unsetExport();
        $crud->unsetPrint();

        $crud->columns(['nombres', 'telefono', 'direccion']);

        $crud->setSubject('CLIENTE');

        $crud->displayAs([
            'nombres' => 'NOMBRE COMPLETO',
            'dni' => 'DNI',
            'telefono' => 'TELEFONO',
            'email' => 'E-MAIL',
            'direccion' => 'DIRECCION'
        ]);

        // Render the CRUD
        $output = $crud->render();
        return $this->_mainOutput($output);
    }
    public function empleados()
    {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('empleados');
        $crud->setSkin('dark');
        $crud->setSubject('EMPLEADO');
        $crud->displayAs([
            'nom_empleado' => 'EMPLEADO',
            'valor_x_hora' => 'VALOR POR HORA (S/.)'
        ]);

        // Render the CRUD
        $output = $crud->render();
        return $this->_mainOutput($output);
    }
    public function roles()
    {
        $crud = $this->_getGroceryCrudEnterprise();

        $crud->setTable('roles');
        $crud->setSkin('dark');
        $crud->fieldType('habilitado', 'dropdown_search', [
            '0' => 'DESHABILITADO',
            '1' => 'HABILITADO'
        ]);
        $crud->setSubject('ROL');
        $crud->displayAs([
            'role_name' => 'ROL',
            'habilitado' => 'ESTADO'
        ]);
        $crud->unsetExport();
        $crud->unsetPrint();
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function users()
    {
        $crud = $this->_getGroceryCrudEnterprise();

        $crud->setTable('users');
        $crud->columns(['username', 'role_id', 'habilitado']);
        $crud->setRelation('role_id', 'roles', 'role_name');
        $crud->setSubject('USUARIO DEL SISTEMA');
        $crud->setSkin('dark');

        $crud->fieldType('habilitado', 'dropdown_search', [
            '0' => 'DESHABILITADO',
            '1' => 'HABILITADO'
        ]);

        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->displayAs([
            'username' => 'USUARIO',
            'role_id' => 'ROL',
            'password' => 'CONTRASEÑA',
            'habilitado' => 'ESTADO'
        ]);
        // Add this callback to transform the username to uppercase in the view
        $crud->callbackColumn('username', function ($value, $row) {
            return strtoupper($value);
        });

        // Modify these callbacks to transform the username to uppercase in the add and edit forms
        $crud->callbackAddField('username', function () {
            return '<input class="form-control" type="text" maxlength="50" name="username" style="text-transform:uppercase">';
        });
        $crud->callbackEditField('username', function ($value, $primaryKey) {
            return '<input class="form-control" type="text" maxlength="50" name="username" value="' . strtoupper($value) . '">';
        });
        $crud->callbackAddField('password', function () {
            return '<input class="form-control" type="password" maxlength="50" name="password" style="width: 500px;max-width: 500px;height: 2.5rem;box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">';
        });
        $crud->callbackEditField('password', function ($postArray, $primaryKey) {
            return $this->editar_campo_password($postArray, $primaryKey);
        });
        $crud->callbackBeforeInsert(function ($stateParameters) {
            return $this->encriptar_password($stateParameters);
        });
        $crud->callbackBeforeUpdate(function ($stateParameters) {
            return $this->actualizar_password($stateParameters);
        });
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function change_password()
    {
        if (session()->get('user_id') != service('uri')->getSegment(service('uri')->getTotalSegments())) {
            return redirect()->to('/');
        } else {
            $crud = $this->_getGroceryCrudEnterprise();

            $crud->setTable('users');
            $crud->setConfig('open_in_modal', false);
            $crud->setSubject('CONTRASEÑA');
            $crud->setSkin('dark');

            $crud->displayAs([
                'password' => 'CONTRASEÑA'
            ]);

            $crud->unsetEditFields(['username', 'role_id', 'habilitado']);
            $crud->editFields(['password']);

            // Modify these callbacks to transform the username to uppercase in the add and edit forms
            $crud->callbackEditField('password', function ($postArray, $primaryKey) {
                return $this->editar_campo_password($postArray, $primaryKey);
            });

            $crud->callbackBeforeUpdate(function ($stateParameters) {
                return $this->actualizar_password($stateParameters);
            });
            $output = $crud->render();

            return $this->_mainOutput($output);
        }
    }
    public function editar_campo_password($postArray, $primaryKey)
    {
        return '<input class="form-control" type="password" maxlength="50" name="password" style="width: 500px;max-width: 500px;height: 2.5rem;box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">';
    }

    public function encriptar_password($stateParameters)
    {
        $stateParameters->data['password'] = md5(sha1($stateParameters->data['password']));
        return $stateParameters;
    }

    public function actualizar_password($stateParameters)
    {
        if (!empty($stateParameters->data['password'])) {
            $stateParameters->data['password'] = md5(sha1($stateParameters->data['password']));
        } else {
            unset($stateParameters->data['password']);
        }
        return $stateParameters;
    }
    public function updateLastUpdatedBy($op_id)
    {
        $db = \Config\Database::connect();

        // Get the user_id from the session
        $user_id = session()->get('user_id');

        // Update the last_updated_by field in the comprobantes table
        $db->query("UPDATE op SET last_updated_by_user_id = ? WHERE id = ?", [$user_id, $op_id]);
    }
}