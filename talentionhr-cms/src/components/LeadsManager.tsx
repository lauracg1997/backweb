
import { Search, Edit2, Trash2, Plus, Target } from 'lucide-react';
import { useState } from 'react';

const initialLeads = [
  { id: 1, name: 'Juan Pérez', email: 'juan@demo.com', status: 'Nuevo' },
  { id: 2, name: 'María García', email: 'maria@demo.com', status: 'Contactado' },
];

export default function LeadsManager() {
  const [leads] = useState(initialLeads);

  return (
    <section id="leads-manager" className="flex flex-col h-full bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
      <header className="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
          <h2 className="text-lg font-semibold text-slate-950">Leads</h2>
          <p className="text-sm text-slate-500">Administra tus contactos y leads.</p>
        </div>
        <button className="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
          <Plus className="w-4 h-4 mr-2" />
          Añadir Lead
        </button>
      </header>
      
      <div className="flex-1 overflow-y-auto">
        <table className="w-full text-left text-sm border-collapse">
          <thead className="text-slate-500 text-xs uppercase border-b border-slate-100 sticky top-0 bg-white">
            <tr>
              <th className="px-6 py-4 font-semibold">Nombre</th>
              <th className="px-6 py-4 font-semibold">Email</th>
              <th className="px-6 py-4 font-semibold">Estado</th>
              <th className="px-6 py-4 font-semibold text-right">Acciones</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-slate-100">
            {leads.map((l) => (
              <tr key={l.id} className="hover:bg-slate-50/50 transition-colors">
                <td className="px-6 py-4 text-slate-950 font-semibold">{l.name}</td>
                <td className="px-6 py-4 text-slate-600">{l.email}</td>
                <td className="px-6 py-4">
                  <span className={`px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700`}>
                    {l.status}
                  </span>
                </td>
                <td className="px-6 py-4 text-right">
                  <button className="text-slate-400 hover:text-blue-600 transition-colors mr-3">
                    <Edit2 className="w-4 h-4" />
                  </button>
                  <button className="text-slate-400 hover:text-red-600 transition-colors">
                    <Trash2 className="w-4 h-4" />
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </section>
  );
}
