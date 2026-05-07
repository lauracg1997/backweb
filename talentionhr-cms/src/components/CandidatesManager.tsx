
import { useState } from 'react';
import { 
  Search, 
  MoreVertical, 
  User, 
  Download, 
  Trash2,
  ArrowLeft,
  Eye,
  Check
} from 'lucide-react';

const initialCandidates = [
  { id: 1, name: 'Marcos Torres', position: 'Frontend Developer', date: 'Hoy, 10:45', status: 'Nuevo' },
  { id: 2, name: 'Elena Rubio', position: 'Product Designer', date: 'Ayer, 18:20', status: 'Revisado' },
  { id: 3, name: 'Javier Lopez', position: 'Marketing Manager', date: '12 Oct, 14:00', status: 'Entrevistado' },
  { id: 4, name: 'Sofía Mendez', position: 'Python Engineer', date: '11 Oct, 09:30', status: 'Nuevo' },
];

export default function CandidatesManager() {
  const [candidates, setCandidates] = useState(initialCandidates);
  const [selectedCandidate, setSelectedCandidate] = useState<any>(null);

  const handleStatusChange = (id: number, newStatus: string) => {
    setCandidates(candidates.map(c => c.id === id ? { ...c, status: newStatus } : c));
    if (selectedCandidate) {
      setSelectedCandidate({ ...selectedCandidate, status: newStatus });
    }
  };

  if (selectedCandidate) {
    return (
      <section className="flex flex-col h-full bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <header className="p-6 border-b border-gray-100 flex items-center bg-gray-50/50">
          <button onClick={() => setSelectedCandidate(null)} className="mr-4 p-2 hover:bg-gray-200 rounded-full">
            <ArrowLeft className="w-5 h-5 text-gray-600" />
          </button>
          <div>
            <h2 className="text-lg font-bold text-gray-900">{selectedCandidate.name}</h2>
            <p className="text-sm text-gray-500">{selectedCandidate.position} • {selectedCandidate.status}</p>
          </div>
        </header>

        <div className="p-6 grid grid-cols-2 gap-8 flex-1">
          <div className="bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
            [Vista previa de CV PDF - {selectedCandidate.name}]
          </div>
          <div className="space-y-4">
            <h3 className="font-semibold text-gray-900">Acciones</h3>
            <div className="flex gap-2">
              {['Nuevo', 'Revisado', 'Entrevistado'].map(status => (
                <button 
                  key={status}
                  onClick={() => handleStatusChange(selectedCandidate.id, status)}
                  className={`px-3 py-1 text-sm rounded ${selectedCandidate.status === status ? 'bg-blue-600 text-white' : 'bg-gray-100 hover:bg-gray-200'}`}
                >
                  Cambiar a {status}
                </button>
              ))}
            </div>
          </div>
        </div>
      </section>
    );
  }

  return (
    <section id="candidates-manager" className="flex flex-col h-full bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
      <header className="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <div>
          <h2 className="text-lg font-bold text-gray-900">Candidatos (CVs)</h2>
          <p className="text-sm text-gray-500">Gestión de todos los CVs recibidos.</p>
        </div>
      </header>
      
      <div className="p-6 border-b border-gray-100 flex gap-4">
        <div className="relative flex-1">
          <Search className="absolute left-3 top-2.5 w-4 h-4 text-gray-400" />
          <input 
            type="text" 
            placeholder="Buscar por candidato o puesto..." 
            className="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20"
          />
        </div>
      </div>

      <div className="flex-1 overflow-y-auto">
        <table className="w-full text-left text-sm border-collapse">
          <thead className="text-gray-500 text-xs uppercase border-b border-gray-100 sticky top-0 bg-white">
            <tr>
              <th className="px-6 py-4 font-semibold">Candidato</th>
              <th className="px-6 py-4 font-semibold">Puesto</th>
              <th className="px-6 py-4 font-semibold">Fecha</th>
              <th className="px-6 py-4 font-semibold">Estado</th>
              <th className="px-6 py-4 font-semibold text-right">Acciones</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-50">
            {candidates.map((c) => (
              <tr key={c.id} className="hover:bg-gray-50/50 transition-colors cursor-pointer" onClick={() => setSelectedCandidate(c)}>
                <td className="px-6 py-4 flex items-center gap-3">
                  <div className="p-2 rounded-lg bg-gray-100 text-gray-500">
                    <User className="w-5 h-5" />
                  </div>
                  <span className="font-medium text-gray-900">{c.name}</span>
                </td>
                <td className="px-6 py-4 text-gray-600">{c.position}</td>
                <td className="px-6 py-4 text-gray-500">{c.date}</td>
                <td className="px-6 py-4">
                  <span className={`px-2.5 py-1 rounded-full text-[11px] font-semibold tracking-wide ${
                    c.status === 'Nuevo' ? 'bg-sky-50 text-sky-700' : 
                    c.status === 'Revisado' ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700'
                  }`}>
                    {c.status}
                  </span>
                </td>
                <td className="px-6 py-4 text-right">
                  <button className="text-gray-400 hover:text-blue-600 transition-colors mr-3" onClick={(e) => { e.stopPropagation(); console.log('Preview', c.id); }}>
                    <Eye className="w-4 h-4" />
                  </button>
                  <button className="text-gray-400 hover:text-blue-600 transition-colors mr-3" onClick={(e) => { e.stopPropagation(); console.log('Download', c.id); }}>
                    <Download className="w-4 h-4" />
                  </button>
                  <button className="text-gray-400 hover:text-red-600 transition-colors" onClick={(e) => { e.stopPropagation(); console.log('Delete', c.id); }}>
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
