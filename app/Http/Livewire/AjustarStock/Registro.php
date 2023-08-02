<?php

namespace App\Http\Livewire\AjustarStock;

use App\Models\AjusteStock;
use App\Models\Arqueo;
use App\Models\DetalleAjusteStock;
use App\Models\Producto;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Registro extends Component
{   
    public $editar_ajuste;
    public $ajuste;
    public $picked2;
    public $productos;
    public $producto_id;
    public $total;
    public $unidad_medida;
    public $cantidad_unidad;
    public $cantidad;
    public $producto_unidad;
    public $cantidad_recuperada;
    public $referencia;
    public $buscarProducto;
    public $tipo_ajuste;
    public $ajuste_id;
    public $precio_compra;
    public $precio_venta;
    public $btn_terminar;
    public $estado; // para verificar si el registro es editable

    protected  $listeners = ['ajusteDetalle'=>'exiteArticulos'];
    public function render()
    {
        return view('livewire.ajustar-stock.registro');
    }

    public function mount(Request $request){

        if (!$request->session()->has('arqueo')) {
            $arqueo = Arqueo::where('estado','=','1')
                    ->where('estado_recibido','=','1')
                    ->where('usuario_id','=',auth()->user()->id)
                    ->pluck('id');
            if (count($arqueo)) {
                session(['arqueo' => $arqueo[0]]);
            }
        }

        $this->productos = [];
        $this->editar_ajuste = false;
        $this->tipo_ajuste = '1';
        $this->referencia = '';
        $this->estado = '2';

        // dd($this->tipo_precio_id);
        if ($this->ajuste_id) { //cunado viene de venta en proceso
            $this->ajuste = AjusteStock::find($this->ajuste_id);
            if ($this->ajuste) {
                $this->tipo_ajuste = $this->ajuste->tipo_ajuste;
                $this->referencia = $this->ajuste->referencia;
                $this->estado = $this->ajuste->estado;
                $cant = DetalleAjusteStock::where('ajuste_stock_id','=',$this->ajuste_id)->count();
                if($cant>0) {
                $this->btn_terminar = true;
                }
            }
        }
    }

    public function updatedbuscarProducto()
    {   
        //$this->clientes = [];
        $this->productos = [];
        $this->producto_id = null;
        $this->cantidad = '';
        $this->total = '';
        //$this->precio = '';
        $this->unidad_medida = '';
        //$this->datos_cliente = null;
        $this->picked2 = false;
        $this->validate([
            "buscarProducto" => "required|min:2"
        ]);
        
        //dd($this->datos_cliente);
        $this->productos = DB::table('productos as p')
                                    ->join('producto_unidads as pu','p.id','=','pu.producto_id')
                                    ->join('unidad_medidas as u','pu.unidad_medida_id','=','u.id')
                                    ->join('producto_precio_clientes as ppc','pu.id','=','ppc.producto_unidad_id')
                                    ->whereRaw('UPPER(p.nombre) like ?',strtoupper(trim($this->buscarProducto)).'%')
                                    ->where('ppc.tipo_cliente_id','=',1) // tener cuidado
                                    ->whereNotNull('ppc.precio_compra')
                                    ->select('p.nombre','p.id','p.stock','ppc.precio_compra',/*'ppc.precio_venta',*/'pu.cantidad_unidades','pu.id as producto_unidad_id','u.nombre as unidad_medida','u.abreviatura')
                                    ->take(3)
                                    ->get();
        //dd($this->productos);
            
    }

    public function asignarProducto($id,$datos,$precio_compra,$unidad,$producto_unidad_id,$cantidad_unidades){
        $this->buscarProducto = $datos;
        $this->producto_id = $id;
        $this->total = number_format($precio_compra,2); 
        $this->precio_compra = $precio_compra;
        $this->unidad_medida = $unidad;
        $this->cantidad_unidad = $cantidad_unidades;
        $this->producto_unidad = $producto_unidad_id;
        $this->cantidad=1;
        $this->cantidad_recuperada = 0.00;
        $this->picked2 = true;
    }

    public function registrarAjuste(){
        $this->validate([
            'producto_id' => 'required',
            'cantidad' => 'required',
            'precio_compra' => 'required',
        ]);
            $fecha = new DateTime();
            $primerRegistro = true;
            if (!$this->ajuste) {
                $primerRegistro = false;
                $referencia = trim($this->referencia);
                $this->ajuste = AjusteStock::create([
                    'tipo_ajuste' => $this->tipo_ajuste,
                    'user_id' => auth()->id(),
                    'fecha' => $fecha->format("Y-m-d H:i:s"),
                    'referencia' => $referencia == '' ? 'AS'.$fecha->format("YmdHis") : $referencia 
                ]);
                $this->estado = $this->ajuste->estado;
            }
            
            $detalle = DetalleAjusteStock::create([
                'ajuste_stock_id' => $this->ajuste->id,
                'producto_id' => $this->producto_id,
                'producto_unidad_id' => $this->producto_unidad,
                'precio_compra' => $this->precio_compra,
                'cantidad' => $this->cantidad,
                'cantidad_unidad' => $this->cantidad_unidad,
                'cantidad_recuperada' => $this->cantidad_recuperada,
                'user_id' => auth()->id()
            ]);
            if ($primerRegistro) {
                $this->limpiar();
                $this->dispatchBrowserEvent('toastr',['message'=>'Registro satisfactorio!!']);
                $this->emit('detalleAjuste',$this->ajuste->id);
            } else {
                redirect('/ajuste-stock/'.$this->ajuste->id);
            }
    }

    public function limpiar(){
        $this->productos = [];
        $this->producto_id = null;
        $this->cantidad = '';
        $this->total = '';
        $this->precio_venta = '';
        $this->unidad_medida = '';
        $this->buscarProducto = '';
        $this->picked2 = false;
    }

    public function updatedcantidad(){
        $this->cantidad == '' ? $this->total = number_format(0,2) : $this->total = number_format($this->cantidad * $this->precio_compra,2);
    }

    public function exiteArticulos($data){
        $this->btn_terminar=$data;
    }

    public function eliminarAjuste(){
        $this->ajuste->delete();
        redirect()->route('ajuste.index');
    }

    public function terminarRegistro( Request $request){

        
        $this->ajuste->update([
            'estado' => '1',
            'arqueo_id' => $request->session()->get('arqueo')
        ]);
        //dd($this->ajuste);
        // calculamos cantidades de cada producto para actualizar el stock
        $detalle = DB::table('detalle_ajuste_stocks as das')
                        ->where('ajuste_stock_id','=',$this->ajuste->id)
                        ->select('producto_id',DB::raw('SUM(das.cantidad*das.cantidad_unidad) as total'))
                        ->groupBy('producto_id')
                        ->get();
        // insertamos los stock en la tabla productos
        foreach ($detalle as $det) {
            $producto = Producto::find($det->producto_id);
            $stock = $producto['stock'] ? $producto['stock'] : 0 ;
            //dd($stock + $det->total);
            $producto->stock = $stock - $det->total;
            try {
                $producto->save();
            } catch (\Throwable $th) {
                $this->dispatchBrowserEvent('toastr-error',['message'=>'Error al actualizar stock']);
            }
        }
        $this->dispatchBrowserEvent('toastr',['message'=>'Registro finalizado.']);
        redirect()->route('ajuste.index');
    }
}
