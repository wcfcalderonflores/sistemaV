<?php

namespace App\Http\Livewire\Modals;

use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Proveedor;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RegistroCliente extends Component
{   
    public $tipo;
    public $cliente_id;
    public $cliente=[];
    public $dataUbigeo=[];
    //public $dataUbigeo=[];
    public $provincias;
    public $distritos;
    public $departamento;
    public $departamentos;
    public $data;
    public $cabecera;
    //protected $listeners = ['modals.registro-cliente'=>'$refresh'];
    protected $listeners = ['modals.registro-cliente'=>'limpiar',
                            'modals.registro-cliente-tipo'=>'tipo',
                            'modals.registro-cliente-data'=>'data',
                            'modals.registro-cliente-limpiar'=>'limpiar',
                            'modals.registro-cliente-clienteId'=>'clienteId',
                            'modals.registro-cliente-cabecera'=>'cabecera',
                            'modals.registro-cliente-dataUbigeo'=>'dataUbigeo'];

    public function limpiar(){
        $this->data=[];
        $this->distritos=[];
        $this->provincias=[];
        $this->departamentos=[];
    }
    public function mount(){
        $this->distritos=[];
        $this->provincias=[];
        $this->departamentos=[];
        $this->data=[];
        $this->cliente_id=null;
        $this->cabecera = 'Cliente';
    }
    public function render()
    {   
        /*if ($this->tipo=='create') {
            $this->limpiar();
        }*/
        
        $departamentos = DB::table('ubigeos')
                        ->select('departamento')
                        ->distinct()->pluck('departamento','departamento');
        $departamentos->prepend('--Seleccione-',null);

        //dd($departamentos);
        return view('livewire.modals.registro-cliente',compact('departamentos'));
    }

    public function dataUbigeo($data){
        $this->dataUbigeo = [];
        $this->provincias = [];
        $this->distritos = [];
        
        if (count($data)>0) {
            $this->dataUbigeo = $data;
            $provincias = DB::table('ubigeos')
                            ->select('provincia')
                            ->distinct()
                            ->where('departamento','=',$this->dataUbigeo['departamento'])
                            ->pluck('provincia','provincia');
            $this->provincias = $provincias->prepend('--Seleccione-',null);
    
            $distritos = DB::table('ubigeos')
                            ->select('id','distrito')
                            ->distinct()
                            ->where('departamento','=',$this->dataUbigeo['departamento'])
                            ->where('provincia','=',$this->dataUbigeo['provincia'])
                            ->pluck('distrito','id');
            $this->distritos = $distritos->prepend('--Seleccione-',null);
        }
        
    }
    public function data($data){
        $this->data = $data;
        //dd($data);
    }
    public function tipo($dato){
        $this->tipo = $dato;
        //if ($this->tipo == 'update') {
            $this->cliente_id = null;
        //}
    }
    public function clienteId(){
        $this->cliente_id = null;
    }
    public function cabecera($data){
        $this->cabecera = $data;
    }
    public function editarClientes(){
        $this->cliente_id = null;
        Validator::make($this->data,[
            'nombre'=> 'required',
            'apellido_paterno'=> 'required',
            'apellido_materno'=> 'required',
            'tipo_documento'=> 'required',
            'numero_documento'=> 'required',
            'sexo' => 'required',
            //'tipo_socio' => $this->cabecera == 'Socio' ? 'required' : '',
            //'ubigeo_id' => 'required',
            //'direccion' => 'required',
            'correo' => 'nullable|unique:personas,correo,'.$this->data['id'],
           
        ])->validate();
        Persona::where('id','=',$this->data['id'])->update([
            'nombre' =>$this->data['nombre'],
            'apellido_paterno' =>$this->data['apellido_paterno'],
            'apellido_materno' =>$this->data['apellido_materno'],
            'tipo_documento' =>$this->data['tipo_documento'],
            'numero_documento' =>$this->data['numero_documento'],
            'sexo' =>$this->data['sexo'],
            'direccion' =>$this->data['direccion'],
            'ubigeo_id' =>$this->data['ubigeo_id'],
            'celular' => $this->data['celular'],
            'correo' => $this->data['correo']==''?NULL:$this->data['correo'],
        ]);
        //dd($this->data);
        /*if ($this->cabecera == 'Socio') {
            Socio::where('persona_id','=',$this->data['id'])->update(['tipo_socio'=>$this->data['tipo_socio']]);
        }*/
        $this->dispatchBrowserEvent('hide-form', ['message'=>$this->cabecera.' actulizado.']);
        $this->data=[];
        $this->provincias = [];
        //dd('list'.$this->cabecera);
        $this->emit('list'.$this->cabecera);
        //return redirect()->back();
        
    }

    public function alexlo(){
        $this->data['numero_documento'] = trim($this->data['numero_documento']);
        if (strlen($this->data['numero_documento'])>7) {
            $persona = Persona::where('numero_documento','=',$this->data['numero_documento'])->get();
            //dd( $persona);
            if (count($persona)>0) {
                
                foreach ($persona as $alex) {
                    $this->data = $alex->toArray();
                }
                
                $departamentos = DB::table('ubigeos')
                            ->select('departamento')
                            ->distinct()->pluck('departamento','departamento');
                $departamentos->prepend('--Seleccione-',null);
                $ubigeo =  Ubigeo::where('id','=',$this->data['ubigeo_id'])->get();
                foreach ($ubigeo as $ubi) {
                    $this->dataUbigeo = $ubi->toArray();
                }
                $this->dataUbigeo($this->dataUbigeo);
                $this->cliente_id = $this->data['id'];
            }
        }    
    }

    public function buscarProvincia($data){
        $this->data['ubigeo_id']=null;
        $this->dataUbigeo['departamento']=$data;
        $this->distritos=[];
        $this->departamento = $data;
        $provincias = DB::table('ubigeos')
                        ->select('provincia')
                        ->distinct()
                        ->where('departamento','=',$data)
                        ->pluck('provincia','provincia');
        $this->provincias = $provincias->prepend('--Seleccione-',null);
    }

    public function buscarDistrito($data){
        $this->dataUbigeo['provincia']=$data;
        $distritos = DB::table('ubigeos')
                        ->select('id','distrito')
                        ->distinct()
                        ->where('departamento','=',$this->departamento)
                        ->where('provincia','=',$data)
                        ->pluck('distrito','id');
        $this->distritos = $distritos->prepend('--Seleccione-',null);
    }

    public function createCliente(){
        //dd($this->cliente_id);
        if ($this->cliente_id != null) { // SI VIENE DE BUSCAR EN LA TABLA PERSONA
            //dd($this->cliente_id);
           if ($this->cabecera =='Cliente'){
            //dd("alexlo");
                $alexlo = Cliente::where('persona_id','=',$this->cliente_id)->first();
                
                if (!$alexlo) { // SI NO ESTA REGISTRADO LO REGISTRAMOS
                    //dd("xxx");
                    $this->dispatchBrowserEvent('hide-form', ['message'=>$this->cabecera.' creado.']);
                    Cliente::create(['persona_id'=>$this->cliente_id]);
                    //dd("xxx");
                }
            }elseif($this->cabecera =='Proveedor'){
                $alexlo = Proveedor::where('persona_id','=',$this->cliente_id)->first();
                if (!$alexlo) { // SI NO ESTA REGISTRADO LO REGISTRAMOS
                    Proveedor::create([
                        'persona_id'=>$this->cliente_id,
                    ]);
                }
            }
            
        }else {
        
            if(isset($this->data['correo'])){
                $this->data['correo'] =   $this->data['correo'] ==''?null: $this->data['correo'];
            }
            //dd($this->data);
            //dd($this->data['tipo_socio']);
            Validator::make($this->data,[
                'nombre'=> 'required',
                'apellido_paterno'=> 'required',
                'apellido_materno'=> 'required',
                'tipo_documento'=> 'required',
                'numero_documento'=> 'required|unique:personas',
                'sexo' => 'required',
                //'tipo_socio' => $this->cabecera =='Socio' ? 'required' : '',
                //'ubigeo_id' => 'required',
               // 'direccion' => 'required',
                'correo' => 'nullable|unique:personas'
            
            ])->validate();
            //dd($this->data);
            //dd($this->cabecera);
            $persona = Persona::create($this->data);
            if($this->cabecera =='Cliente'){
                $clienteAll = new Cliente();
                $clienteAll->persona_id = $persona->id;
                $clienteAll->save();
                //Cliente::create(['persona_id'=>$persona->id]);
            }
            elseif($this->cabecera =='Proveedor'){
                Proveedor::create([
                    'persona_id'=>$persona->id
                ]);

            }
        }
        $this->dispatchBrowserEvent('hide-form', ['message'=>$this->cabecera.' creado.']);
        $this->limpiar();
        $this->emit('list'.$this->cabecera);
        return redirect()->back();
    }
}
