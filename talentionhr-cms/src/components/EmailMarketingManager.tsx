
import { Search, Edit2, Trash2, Plus, Mail } from 'lucide-react';
import { useState } from 'react';
import NewsletterManager from './NewsletterManager';

const initialCampaigns = [
  { id: 1, name: 'Bienvenida nuevos leads', status: 'Activa', openRate: '45%' },
  { id: 2, name: 'Reactivación RRHH', status: 'Borrador', openRate: '0%' },
];

export default function EmailMarketingManager() {
  const [activeTab, setActiveTab] = useState<'Campaigns' | 'Newsletter'>('Campaigns');
  const [campaigns] = useState(initialCampaigns);

  return (
    <section id="email-marketing-manager" className="flex flex-col h-full bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
      <header className="px-6 pt-6 border-b border-slate-100 flex justify-between items-end bg-slate-50/50">
        <div>
          <h2 className="text-lg font-semibold text-slate-950">Email & News</h2>
          <div className="flex gap-4 mt-4">
            <button 
              onClick={() => setActiveTab('Campaigns')}
              className={`pb-3 text-sm font-semibold border-b-2 ${activeTab === 'Campaigns' ? 'text-blue-600 border-blue-600' : 'text-slate-500 border-transparent hover:text-slate-700'}`}
            >
              Campañas
            </button>
            <button 
              onClick={() => setActiveTab('Newsletter')}
              className={`pb-3 text-sm font-semibold border-b-2 ${activeTab === 'Newsletter' ? 'text-blue-600 border-blue-600' : 'text-slate-500 border-transparent hover:text-slate-700'}`}
            >
              Newsletter
            </button>
          </div>
        </div>
        {activeTab === 'Campaigns' && (
          <button className="flex items-center px-4 py-2 mb-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
            <Plus className="w-4 h-4 mr-2" />
            Nueva campaña
          </button>
        )}
      </header>
      
      <div className="flex-1 overflow-y-auto">
        {activeTab === 'Campaigns' ? (
          <table className="w-full text-left text-sm border-collapse">
            <thead className="text-slate-500 text-xs uppercase border-b border-slate-100 sticky top-0 bg-white">
              <tr>
                <th className="px-6 py-4 font-semibold">Nombre</th>
                <th className="px-6 py-4 font-semibold">Estado</th>
                <th className="px-6 py-4 font-semibold">Tasa Apertura</th>
                <th className="px-6 py-4 font-semibold text-right">Acciones</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100">
              {campaigns.map((c) => (
                <tr key={c.id} className="hover:bg-slate-50/50 transition-colors">
                  <td className="px-6 py-4 text-slate-950 font-semibold">{c.name}</td>
                  <td className="px-6 py-4">
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${c.status === 'Activa' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}`}>
                      {c.status}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-slate-600">{c.openRate}</td>
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
        ) : (
          <NewsletterManager />
        )}
      </div>
    </section>
  );
}
