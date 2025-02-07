<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin     = Role::create(['name' => 'admin']);
        $tecnico   = Role::create(['name' => 'tecnico']);
        $empresa   = Role::create(['name' => 'empresa']);
        $operario  = Role::create(['name' => 'operario']);
        $proveedor = Role::create(['name' => 'proveedor']);
        $cliente   = Role::create(['name' => 'cliente']);


        Permission::create(['name' => 'home'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.users.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.roles.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roles.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roles.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roles.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roles.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roles.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.permissions.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.permissions.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.permissions.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.permissions.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.permissions.update'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.citas.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.citas.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.citas.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.citas.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.citas.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.citas.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.clientes.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.clientes.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.clientes.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.clientes.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.clientes.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.clientes.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.tipo-clientes.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiposclientes.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiposclientes.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiposclientes.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiposclientes.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.ciudades.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ciudades.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ciudades.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ciudades.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ciudades.edit'])->syncRoles([$admin]);
        
        Permission::create(['name' => 'admin.bancos.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.bancos.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.bancos.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.bancos.details'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.bancos.import'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.trabajos.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.trabajos.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.trabajos.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.trabajos.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.trabajos.update'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.operarios.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.operarios.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.operarios.getskills'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.operarios.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.operarios.update'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.ordenes.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ordenes.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ordenes.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ordenes.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ordenes.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ordenes.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.proveedores.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.proveedores.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.proveedores.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.proveedores.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.proveedores.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.proveedores.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.empresas.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.empresas.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.empresas.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.empresas.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.empresas.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.empresas.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.tipo-empresas.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiposempresas.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.tiposempresas.update'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.compras.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.compras.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.compras.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.compras.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.compras.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.compras.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.lineas.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineas.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineas.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineas.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineas.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineas.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.articulos.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.articulos.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.articulos.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.articulos.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.articulos.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.articulos.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.categorias.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.categorias.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.categorias.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.categorias.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.categorias.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.categorias.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.stock.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.stock.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.stock.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.stock.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.stock.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.stock.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.pagoscompras.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pagoscompras.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pagoscompras.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pagoscompras.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pagoscompras.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.pagoscompras.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.ventas.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ventas.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ventas.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ventas.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ventas.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ventas.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.lineasventas.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineasventas.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineasventas.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineasventas.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineasventas.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineasventas.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.projects.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.projects.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.projects.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.projects.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.projects.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.projects.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.partes.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.partes.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.partes.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.partes.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.partes.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.partes.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.lineaspartes.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspartes.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspartes.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspartes.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspartes.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspartes.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.dashboard.getInfo'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.presupuestos.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.getpartes'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.updatesum'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.generateOrden'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.presupuestos.generarPDF'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.lineaspresupuestos.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspresupuestos.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspresupuestos.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspresupuestos.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspresupuestos.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.lineaspresupuestos.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.traspasos.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.traspasos.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.traspasos.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.traspasos.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.traspasos.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.traspasos.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.traspasos.generarPDF'])->syncRoles([$admin]);


    }
}
