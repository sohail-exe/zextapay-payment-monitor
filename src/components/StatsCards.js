import { formatCurrency } from '../utils/api';

const StatsCards = ({ stats }) => {
    return (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            { /* Success Count */}
            <div className="bg-emerald-500 rounded-[3rem] p-8 text-white shadow-2xl shadow-emerald-500/20 relative overflow-hidden group hover:scale-[1.02] transition-transform cursor-default">
                <div className="relative z-10">
                    <p className="text-[9px] font-black uppercase tracking-[0.2em] text-emerald-100/60 mb-2">Success Rate</p>
                    <h4 className="text-3xl font-extrabold tracking-tight">{stats?.total_success || 0}</h4>
                    <p className="text-[10px] font-bold text-emerald-100/40 mt-1 uppercase tracking-widest">Healthy Orders</p>
                </div>
            </div>

            { /* Failure Count */}
            <div className="bg-rose-500 rounded-[3rem] p-8 text-white shadow-2xl shadow-rose-500/20 relative overflow-hidden group hover:scale-[1.02] transition-transform cursor-default">
                <div className="relative z-10">
                    <p className="text-[9px] font-black uppercase tracking-[0.2em] text-rose-100/60 mb-2">Checkout Fails</p>
                    <h4 className="text-3xl font-extrabold tracking-tight">{stats?.total_failures || 0}</h4>
                    <p className="text-[10px] font-bold text-rose-100/40 mt-1 uppercase tracking-widest">Revenue at risk</p>
                </div>
            </div>

            { /* Recoverable Revenue */}
            <div className="col-span-1 md:col-span-2 rounded-[4rem] bg-gradient-to-br from-slate-700 to-slate-900 p-10 text-white shadow-2xl relative overflow-hidden group cursor-default">
                <div className="relative z-10 flex flex-col justify-center h-full">
                    <p className="text-[10px] font-black uppercase tracking-[0.4em] text-white/40 mb-3">Recoverable Revenue</p>
                    <div className="flex items-baseline gap-2">
                        <h4 className="text-6xl font-extrabold tracking-tighter leading-none">
                            {formatCurrency(stats?.recoverable_revenue)}
                        </h4>
                        <div className="bg-white/10 px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase">
                            Live Protection
                        </div>
                    </div>
                </div>
            </div>

        </div>
    );
};

export default StatsCards;