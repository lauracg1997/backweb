
import { Search, Edit2, Trash2, Plus, Users } from 'lucide-react';
import { useState } from 'react';

const initialNewsletters = [
  { id: 1, name: 'Newsletter Semanal', subscribers: 1250, lastSent: '2026-05-01' },
  { id: 2, name: 'Tips Reclutamiento', subscribers: 890, lastSent: '2026-04-28' },
];

export default function NewsletterManager() {
  const [newsletters] = useState(initialNewsletters);

  return (
    <section id="newsletter-manager" className="flex flex-col h-full bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
      <header className="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
          <h2 className="text-lg font-semibold text-slate-950">Newsletter</h2>
          <p className="text-sm text-slate-500">Administra tus listas y envíos de newsletter.</p>
        </div>
        <button className="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
          <Plus className="w-4 h-4 mr-2" />
          Nueva campaña
        </button>
      </header>
      
      <div className="flex-1 overflow-y-auto">
        <table className="w-full text-left text-sm border-collapse">
          <thead className="text-slate-500 text-xs uppercase border-b border-slate-100 sticky top-0 bg-white">
            <tr>
              <th className="px-6 py-4 font-semibold">Nombre</th>
              <th className="px-6 py-4 font-semibold">Suscriptores</th>
              <th className="px-6 py-4 font-semibold">Último Envío</th>
              <th className="px-6 py-4 font-semibold text-right">Acciones</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-slate-100">
            {newsletters.map((n) => (
              <tr key={n.id} className="hover:bg-slate-50/50 transition-colors">
                <td className="px-6 py-4 text-slate-950 font-semibold">{n.name}</td>
                <td className="px-6 py-4 text-slate-600 flex items-center">
                    <Users className="w-3 h-3 mr-1.5 text-slate-400" />
                    {n.subscribers}
                </td>
                <td className="px-6 py-4 text-slate-600">{n.lastSent}</td>
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
