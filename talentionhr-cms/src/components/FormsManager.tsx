
import { Search, Eye, Trash2, MessageSquare } from 'lucide-react';
import { useState } from 'react';

const initialForms = [
  { id: 1, name: 'Juan Perez', email: 'juan@demo.com', phone: '654321987', company: 'Tech Inc', employees: '51-100', message: 'Hola, quiero información', date: 'Hoy', source: 'web' },
  { id: 2, name: 'María García', email: 'maria@empresa.es', phone: '611223344', company: 'Soluciones S.A.', employees: '201-500', message: 'Interesado en sus servicios', date: 'Ayer', source: 'resource', resourceName: 'Guia_SEO_2024.pdf' },
];

export default function FormsManager() {
  const [forms] = useState(initialForms);
  const [openMessage, setOpenMessage] = useState<string | null>(null);

  return (
    <section id="forms-manager" className="flex flex-col h-full bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
      <header className="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
          <h2 className="text-lg font-semibold text-slate-950">Formularios Recibidos</h2>
          <p className="text-sm text-slate-500">Registro de todas las consultas de clientes.</p>
        </div>
      </header>
      
      <div className="p-6 border-b border-slate-100 flex gap-4">
        <div className="relative flex-1">
          <Search className="absolute left-3 top-2.5 w-4 h-4 text-slate-400" />
          <input 
            type="text" 
            placeholder="Buscar por nombre, empresa o email..." 
            className="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20"
          />
        </div>
      </div>

      <div className="flex-1 overflow-y-auto">
        <table className="w-full text-left text-sm border-collapse">
          <thead className="text-slate-500 text-xs uppercase border-b border-slate-100 sticky top-0 bg-white">
            <tr>
              <th className="px-6 py-4 font-semibold">Nombre y apellidos</th>
              <th className="px-6 py-4 font-semibold">Empresa</th>
              <th className="px-6 py-4 font-semibold">Tamaño</th>
              <th className="px-6 py-4 font-semibold">Contacto</th>
              <th className="px-6 py-4 font-semibold">Origen</th>
              <th className="px-6 py-4 font-semibold">Fecha</th>
              <th className="px-6 py-4 font-semibold text-right">Acciones</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-slate-100">
            {forms.map((f) => (
              <tr key={f.id} className="hover:bg-slate-50/50 transition-colors">
                <td className="px-6 py-4 text-slate-950 font-semibold">{f.name}</td>
                <td className="px-6 py-4 text-slate-600">{f.company}</td>
                <td className="px-6 py-4 text-slate-600">{f.employees}</td>
                <td className="px-6 py-4">
                    <p className="text-slate-950 font-medium">{f.email}</p>
                    <p className="text-xs text-slate-500">{f.phone}</p>
                </td>
                <td className="px-6 py-4">
                    <span className={`px-2.5 py-1 rounded-full text-[11px] font-semibold tracking-wide ${f.source === 'web' ? 'bg-sky-50 text-sky-700' : 'bg-emerald-50 text-emerald-700'}`}>
                        {f.source === 'web' ? 'Formulario Web' : `Descarga: ${f.resourceName}`}
                    </span>
                </td>
                <td className="px-6 py-4 text-slate-500">{f.date}</td>
                <td className="px-6 py-4 text-right">
                  {f.message && (
                    <button onClick={() => setOpenMessage(f.message)} className="text-slate-400 hover:text-blue-600 transition-colors mr-3">
                        <MessageSquare className="w-4 h-4" />
                    </button>
                    )}
                  <button className="text-slate-400 hover:text-blue-600 transition-colors mr-3">
                    <Eye className="w-4 h-4" />
                  </button>
                  <button className="text-slate-400 hover:text-slate-950 transition-colors">
                    <Trash2 className="w-4 h-4" />
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      {openMessage && (
        <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div className="bg-white p-6 rounded-2xl shadow-xl w-full max-w-sm">
            <h3 className="font-semibold text-slate-950 mb-2">Mensaje del cliente</h3>
            <p className="text-slate-600 text-sm mb-4">{openMessage}</p>
            <button onClick={() => setOpenMessage(null)} className="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">Cerrar</button>
          </div>
        </div>
      )}
    </section>
  );
}
