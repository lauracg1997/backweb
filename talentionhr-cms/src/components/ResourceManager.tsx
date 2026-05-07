
import { useState } from 'react';
import { 
  Plus, 
  Search, 
  MoreVertical, 
  FileBadge, 
  FileArchive, 
  Download, 
  X
} from 'lucide-react';

const initialResources = [
  { id: 1, name: 'Guia_SEO_2024.pdf', size: '3.4 MB', downloads: 1245, type: 'pdf', date: 'Oct 12, 2024', status: 'active', category: 'Guía' },
  { id: 2, name: 'Icon_Pack_V2.zip', size: '12.1 MB', downloads: 892, type: 'zip', date: 'Oct 05, 2024', status: 'active', category: 'Plantilla' },
  { id: 3, name: 'Brand_Assets.zip', size: '48.2 MB', downloads: 412, type: 'zip', date: 'Sep 28, 2024', status: 'active', category: 'Demo' },
];

export default function ResourceManager() {
  const [isAdding, setIsAdding] = useState(false);
  const [openDropdownId, setOpenDropdownId] = useState<number | null>(null);
  const [resources, setResources] = useState(initialResources);

  const handleAction = (action: string, res: any) => {
    setOpenDropdownId(null);
    switch (action) {
      case 'download':
        console.log('Descargando:', res.name);
        break;
      case 'edit':
        console.log('Editando:', res.name);
        alert(`Editando ${res.name}`);
        break;
      case 'disable':
        setResources(prev => prev.map(r => r.id === res.id ? { ...r, status: r.status === 'active' ? 'disabled' : 'active' } : r));
        break;
      case 'delete':
        if (confirm(`¿Eliminar ${res.name}?`)) {
          setResources(prev => prev.filter(r => r.id !== res.id));
        }
        break;
      case 'viewClients':
        console.log('Ver clientes para:', res.name);
        alert(`Ver potenciales clientes de ${res.name}`);
        break;
    }
  };

  if (isAdding) {
    return (
      <section className="flex flex-col h-full bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <header className="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
          <div>
            <h2 className="text-lg font-bold text-gray-900">Añadir Nuevo Recurso</h2>
            <p className="text-sm text-gray-500">Rellena los detalles para añadir un nuevo recurso.</p>
          </div>
          <button onClick={() => setIsAdding(false)} className="text-gray-400 hover:text-gray-900">
            <X className="w-6 h-6" />
          </button>
        </header>

        <form className="p-6 space-y-4 overflow-y-auto">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">Título</label>
            <input type="text" className="w-full text-sm border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20" />
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
            <select className="w-full text-sm border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20">
              <option>Demo</option>
              <option>Guía</option>
              <option>Plantilla</option>
              <option>Webinar</option>
            </select>
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea className="w-full text-sm border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-blue-500/20" rows={3}></textarea>
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">Imagen de muestra <span className="text-gray-400 font-normal">(1024x576 px)</span></label>
            <input type="file" className="w-full text-sm border border-gray-200 rounded-lg p-2" />
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">Recurso (Archivo o Enlace)</label>
            <input type="file" className="w-full text-sm border border-gray-200 rounded-lg p-2 mb-2" />
            <input type="text" placeholder="O enlace externo" className="w-full text-sm border border-gray-200 rounded-lg p-2" />
          </div>
          <div className="pt-4 flex gap-3">
            <button type="button" onClick={() => setIsAdding(false)} className="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</button>
            <button type="submit" className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Guardar Recurso</button>
          </div>
        </form>
      </section>
    );
  }

  return (
    <section id="resource-manager" className="flex flex-col h-full bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
      <header className="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <div>
          <h2 className="text-lg font-bold text-gray-900">Gestión de Recursos</h2>
          <p className="text-sm text-gray-500">Administra tus archivos descargables para la web.</p>
        </div>
        <button onClick={() => setIsAdding(true)} className="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 transition">
          <Plus className="w-4 h-4 mr-2" />
          Añadir Recurso
        </button>
      </header>
      
      <div className="p-6 border-b border-gray-100 flex gap-4">
        <div className="relative flex-1">
          <Search className="absolute left-3 top-2.5 w-4 h-4 text-gray-400" />
          <input 
            type="text" 
            placeholder="Buscar recursos..." 
            className="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20"
          />
        </div>
      </div>

      <div className="flex-1 overflow-y-auto">
        <table className="w-full text-left text-sm border-collapse">
          <thead className="text-gray-500 text-xs uppercase border-b border-gray-100 sticky top-0 bg-white">
            <tr>
              <th className="px-6 py-4 font-semibold">Nombre</th>
              <th className="px-6 py-4 font-semibold">Categoría</th>
              <th className="px-6 py-4 font-semibold">Tipo</th>
              <th className="px-6 py-4 font-semibold">Tamaño</th>
              <th className="px-6 py-4 font-semibold">Descargas</th>
              <th className="px-6 py-4 font-semibold">Fecha</th>
              <th className="px-6 py-4 font-semibold text-right">Acciones</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-50">
            {resources.map((res) => (
              <tr key={res.id} className="hover:bg-gray-50/50 transition-colors">
                <td className="px-6 py-4 flex items-center gap-3">
                  <div className={`p-2 rounded-lg ${res.type === 'pdf' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600'}`}>
                    {res.type === 'pdf' ? <FileBadge className="w-5 h-5" /> : <FileArchive className="w-5 h-5" />}
                  </div>
                  <span className="font-medium text-gray-900">{res.name}</span>
                </td>
                <td className="px-6 py-4 text-gray-500">{res.category}</td>
                <td className="px-6 py-4 text-gray-500 uppercase text-xs">{res.type}</td>
                <td className="px-6 py-4 text-gray-500">{res.size}</td>
                <td className="px-6 py-4 text-gray-900 font-medium">{res.downloads.toLocaleString()}</td>
                <td className="px-6 py-4 text-gray-500">{res.date}</td>
                <td className="px-6 py-4 text-right relative">
                  <button 
                    onClick={() => setOpenDropdownId(openDropdownId === res.id ? null : res.id)}
                    className="text-gray-400 hover:text-gray-900 transition-colors"
                  >
                    <MoreVertical className="w-4 h-4" />
                  </button>
                  
                  {openDropdownId === res.id && (
                    <div className="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-lg z-20 py-1 text-left">
                      <button onClick={() => handleAction('download', res)} className="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Descargar recurso</button>
                      <button onClick={() => handleAction('edit', res)} className="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Editar recurso</button>
                      <button onClick={() => handleAction('disable', res)} className="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        {res.status === 'active' ? 'Deshabilitar' : 'Habilitar'} recurso
                      </button>
                      <button onClick={() => handleAction('delete', res)} className="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Eliminar recurso</button>
                      <button onClick={() => handleAction('viewClients', res)} className="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Ver potenciales clientes</button>
                    </div>
                  )}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </section>
  );
}
