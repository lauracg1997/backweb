
import { Search, Edit2, Trash2, Plus, Calendar, Image as ImageIcon, Link2 } from 'lucide-react';
import { useState, useRef } from 'react';

const initialPosts = [
  { id: 1, title: 'Cómo mejorar el reclutamiento', status: 'Publicado', date: '2026-05-01', content: 'Contenido aquí...', coverImage: null },
  { id: 2, title: 'Tendencias en RRHH 2026', status: 'Borrador', date: '2026-05-04', content: 'Contenido aquí...', coverImage: null },
];

export default function BlogManager() {
  const [posts, setPosts] = useState(initialPosts);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [newPost, setNewPost] = useState({ title: '', content: '', coverImage: null as File | null });
  const [isUrlModalOpen, setIsUrlModalOpen] = useState(false);
  const [linkUrl, setLinkUrl] = useState('');
  const [selection, setSelection] = useState({ start: 0, end: 0, selectedText: '' });
  const contentRef = useRef<HTMLTextAreaElement>(null);

  const handleAddLink = () => {
    const textarea = contentRef.current;
    if (!textarea) return;
    setSelection({
      start: textarea.selectionStart,
      end: textarea.selectionEnd,
      selectedText: textarea.value.substring(textarea.selectionStart, textarea.selectionEnd)
    });
    setIsUrlModalOpen(true);
  };

  const confirmAddLink = () => {
    const textarea = contentRef.current;
    if (!textarea) return;
    const { start, end, selectedText } = selection;
    const newContent = textarea.value.substring(0, start) + 
                       `[${selectedText || 'Enlace'}](http://${linkUrl})` + 
                       textarea.value.substring(end);
    setNewPost({...newPost, content: newContent});
    setIsUrlModalOpen(false);
    setLinkUrl('');
  };

  const handleCreatePost = () => {
    const post = {
        id: posts.length + 1,
        title: newPost.title,
        status: 'Borrador',
        date: new Date().toISOString().split('T')[0],
        content: newPost.content,
        coverImage: newPost.coverImage
    };
    setPosts([...posts, post]);
    setIsModalOpen(false);
    setNewPost({ title: '', content: '', coverImage: null });
  };

  return (
    <section id="blog-manager" className="flex flex-col h-full bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
      <header className="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
          <h2 className="text-lg font-semibold text-slate-950">Gestión del Blog</h2>
          <p className="text-sm text-slate-500">Administra las entradas de tu blog.</p>
        </div>
        <button onClick={() => setIsModalOpen(true)} className="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
          <Plus className="w-4 h-4 mr-2" />
          Nueva entrada
        </button>
      </header>
      
      <div className="p-6 border-b border-slate-100 flex gap-4">
        <div className="relative flex-1">
          <Search className="absolute left-3 top-2.5 w-4 h-4 text-slate-400" />
          <input 
            type="text" 
            placeholder="Buscar por título..." 
            className="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20"
          />
        </div>
      </div>

      <div className="flex-1 overflow-y-auto">
        <table className="w-full text-left text-sm border-collapse">
          <thead className="text-slate-500 text-xs uppercase border-b border-slate-100 sticky top-0 bg-white">
            <tr>
              <th className="px-6 py-4 font-semibold">Título</th>
              <th className="px-6 py-4 font-semibold">Estado</th>
              <th className="px-6 py-4 font-semibold">Fecha</th>
              <th className="px-6 py-4 font-semibold text-right">Acciones</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-slate-100">
            {posts.map((p) => (
              <tr key={p.id} className="hover:bg-slate-50/50 transition-colors">
                <td className="px-6 py-4 text-slate-950 font-semibold">{p.title}</td>
                <td className="px-6 py-4">
                  <span className={`px-2 py-1 rounded-full text-xs font-medium ${p.status === 'Publicado' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}`}>
                    {p.status}
                  </span>
                </td>
                <td className="px-6 py-4 text-slate-600 flex items-center">
                    <Calendar className="w-3 h-3 mr-1.5 text-slate-400" />
                    {p.date}
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

      {isModalOpen && (
        <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div className="bg-white p-6 rounded-2xl shadow-xl w-full max-w-lg relative">
            <h3 className="font-semibold text-slate-950 mb-4">Nueva entrada</h3>
            <div className="space-y-4">
              <input type="text" placeholder="Título" className="w-full p-2 border border-slate-200 rounded-lg text-sm" value={newPost.title} onChange={e => setNewPost({...newPost, title: e.target.value})} />
              <div className="flex gap-2">
                <button onClick={handleAddLink} className="p-2 bg-slate-100 text-slate-600 rounded-lg"><Link2 className="w-4 h-4" /></button>
                <label className="p-2 bg-slate-100 text-slate-600 rounded-lg cursor-pointer">
                  <ImageIcon className="w-4 h-4" />
                  <input type="file" className="hidden" onChange={e => setNewPost({...newPost, coverImage: e.target.files?.[0] || null})} />
                </label>
              </div>
              {newPost.coverImage && (
                <div className="mt-2">
                    <img 
                      src={URL.createObjectURL(newPost.coverImage)} 
                      alt="Preview" 
                      className="w-20 h-20 object-cover rounded-lg border-2 border-blue-100" 
                    />
                </div>
              )}
              <textarea ref={contentRef} placeholder="Contenido" className="w-full p-2 border border-slate-200 rounded-lg text-sm h-40" value={newPost.content} onChange={e => setNewPost({...newPost, content: e.target.value})} />
            </div>
            {isUrlModalOpen && (
                <div className="absolute inset-0 bg-black/20 flex items-center justify-center z-10">
                    <div className="bg-white p-4 rounded-xl shadow-lg w-64">
                        <input type="text" placeholder="URL (ej: google.com)" className="w-full p-2 border border-slate-200 rounded-lg text-sm mb-2" value={linkUrl} onChange={e => setLinkUrl(e.target.value)} />
                        <div className="flex gap-2">
                            <button onClick={() => setIsUrlModalOpen(false)} className="flex-1 py-1 bg-slate-100 rounded text-xs">Cancelar</button>
                            <button onClick={confirmAddLink} className="flex-1 py-1 bg-blue-600 text-white rounded text-xs">Aceptar</button>
                        </div>
                    </div>
                </div>
            )}
            <div className="flex gap-2 mt-6">
                <button onClick={() => setIsModalOpen(false)} className="flex-1 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium">Cancelar</button>
                <button onClick={handleCreatePost} className="flex-1 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">Publicar</button>
            </div>
          </div>
        </div>
      )}
    </section>
  );
}
