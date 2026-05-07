
import { Search, Edit2, Trash2, UserPlus } from 'lucide-react';
import { useState } from 'react';

const initialUsers = [
  { id: 1, name: 'Admin Principal', email: 'admin@talentionhr.es', role: 'Administrador' },
  { id: 2, name: 'Marketing User', email: 'marketing@talentionhr.es', role: 'Editor' },
];

const initialRoles = [
  { id: 1, name: 'Administrador', description: 'Acceso total al CMS.' },
  { id: 2, name: 'Editor', description: 'Puede editar y crear recursos, formularios y candidatos.' },
];

export default function UsersManager() {
  const [activeTab, setActiveTab] = useState<'Usuarios' | 'Roles'>('Usuarios');
  const [users] = useState(initialUsers);
  const [roles] = useState(initialRoles);
  const [isAddModalOpen, setIsAddModalOpen] = useState(false);
  const [newUser, setNewUser] = useState({ name: '', email: '', password: '', role: 'Editor' });

  const handleAddUser = () => {
    // Here we would handle the user addition logic
    setIsAddModalOpen(false);
    setNewUser({ name: '', email: '', password: '', role: 'Editor' });
  };

  return (
    <section id="users-manager" className="flex flex-col h-full bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
      <header className="px-6 pt-6 border-b border-slate-100 flex justify-between items-end bg-slate-50/50">
        <div>
          <h2 className="text-lg font-semibold text-slate-950">Gestión de Usuarios</h2>
          <div className="flex gap-4 mt-4">
            <button 
              onClick={() => setActiveTab('Usuarios')}
              className={`pb-3 text-sm font-semibold border-b-2 ${activeTab === 'Usuarios' ? 'text-blue-600 border-blue-600' : 'text-slate-500 border-transparent hover:text-slate-700'}`}
            >
              Usuarios
            </button>
            <button 
              onClick={() => setActiveTab('Roles')}
              className={`pb-3 text-sm font-semibold border-b-2 ${activeTab === 'Roles' ? 'text-blue-600 border-blue-600' : 'text-slate-500 border-transparent hover:text-slate-700'}`}
            >
              Roles
            </button>
          </div>
        </div>
        {activeTab === 'Usuarios' && (
          <button 
            onClick={() => setIsAddModalOpen(true)}
            className="flex items-center px-4 py-2 mb-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition"
          >
            <UserPlus className="w-4 h-4 mr-2" />
            Añadir usuario
          </button>
        )}
      </header>
      
      {activeTab === 'Usuarios' ? (
        <>
          <div className="p-6 border-b border-slate-100 flex gap-4">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-2.5 w-4 h-4 text-slate-400" />
              <input 
                type="text" 
                placeholder="Buscar por nombre o email..." 
                className="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20"
              />
            </div>
          </div>

          <div className="flex-1 overflow-y-auto">
            <table className="w-full text-left text-sm border-collapse">
              <thead className="text-slate-500 text-xs uppercase border-b border-slate-100 sticky top-0 bg-white">
                <tr>
                  <th className="px-6 py-4 font-semibold">Nombre</th>
                  <th className="px-6 py-4 font-semibold">Email</th>
                  <th className="px-6 py-4 font-semibold">Rol</th>
                  <th className="px-6 py-4 font-semibold text-right">Acciones</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100">
                {users.map((u) => (
                  <tr key={u.id} className="hover:bg-slate-50/50 transition-colors">
                    <td className="px-6 py-4 text-slate-950 font-semibold">{u.name}</td>
                    <td className="px-6 py-4 text-slate-600">{u.email}</td>
                    <td className="px-6 py-4 text-slate-600">{u.role}</td>
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
        </>
      ) : (
        <div className="flex-1 overflow-y-auto">
          <table className="w-full text-left text-sm border-collapse">
            <thead className="text-slate-500 text-xs uppercase border-b border-slate-100 sticky top-0 bg-white">
              <tr>
                <th className="px-6 py-4 font-semibold">Nombre</th>
                <th className="px-6 py-4 font-semibold">Descripción</th>
                <th className="px-6 py-4 font-semibold text-right">Acciones</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100">
              {roles.map((r) => (
                <tr key={r.id} className="hover:bg-slate-50/50 transition-colors">
                  <td className="px-6 py-4 text-slate-950 font-semibold">{r.name}</td>
                  <td className="px-6 py-4 text-slate-600">{r.description}</td>
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
      )}
      
      {isAddModalOpen && (
        <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div className="bg-white p-6 rounded-2xl shadow-xl w-full max-w-sm">
            <h3 className="font-semibold text-slate-950 mb-4">Añadir nuevo usuario</h3>
            <div className="space-y-3 mb-4">
              <input type="text" placeholder="Nombre" className="w-full p-2 border border-slate-200 rounded-lg text-sm" value={newUser.name} onChange={e => setNewUser({...newUser, name: e.target.value})} />
              <input type="email" placeholder="Correo" className="w-full p-2 border border-slate-200 rounded-lg text-sm" value={newUser.email} onChange={e => setNewUser({...newUser, email: e.target.value})} />
              <input type="password" placeholder="Contraseña inicial" className="w-full p-2 border border-slate-200 rounded-lg text-sm" value={newUser.password} onChange={e => setNewUser({...newUser, password: e.target.value})} />
              <select className="w-full p-2 border border-slate-200 rounded-lg text-sm" value={newUser.role} onChange={e => setNewUser({...newUser, role: e.target.value})}>
                <option>Administrador</option>
                <option>Editor</option>
              </select>
            </div>
            <div className="flex gap-2">
                <button onClick={() => setIsAddModalOpen(false)} className="flex-1 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium">Cancelar</button>
                <button onClick={handleAddUser} className="flex-1 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">Guardar</button>
            </div>
          </div>
        </div>
      )}
    </section>
  );
}
