import { useState, useEffect } from '@wordpress/element';
import StatsCards from './StatsCards';
import TransactionTable from './TransactionTable';
import { fetchStats, fetchLogs } from '../utils/api';

const App = () => {
    const [stats, setStats] = useState(null);
    const [logs, setLogs] = useState([]);

    const loadData = () => {
        fetchStats().then(setStats);
        fetchLogs().then((data) => setLogs(data || []));
    };

    useEffect(() => {
        loadData();

        const link = document.createElement('link');
        link.href = 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap';
        link.rel = 'stylesheet';
        document.head.appendChild(link);
    }, []);

    return (
        <div className="p-12 bg-[#fcfdfe] min-h-screen text-slate-900" style={{ fontFamily: "'Outfit', sans-serif" }}>

            {/* Header */}
            <div className="max-w-4xl mx-auto flex items-center mb-16">
                <div className="flex items-center gap-4">
                    <div className="w-12 h-12 bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h1 className="text-2xl font-extrabold tracking-tight">ZextaPay</h1>
                        <span className="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">free version</span>
                    </div>
                </div>
            </div>

            {/* Content */}
            <div className="max-w-4xl mx-auto">
                <div className="space-y-12">
                    <StatsCards stats={stats} />
                    <TransactionTable logs={logs} />
                </div>
            </div>

        </div>
    );
};

export default App;