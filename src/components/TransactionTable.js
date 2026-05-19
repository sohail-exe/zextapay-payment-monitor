import { formatCurrency } from '../utils/api';

const TransactionTable = ({ logs }) => {
    return (
        <div className="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table className="w-full text-left">
                <tbody className="divide-y divide-slate-50">
                    {logs.map((log) => (
                        <tr key={log.id} className="group hover:bg-slate-50/50 transition-all">

                            { /* Order ID */}
                            <td className="px-10 py-8 font-extrabold text-slate-900">
                                #{log.order_id}
                            </td>

                            { /* Gateway */}
                            <td className="px-10 py-8">
                                <span className="px-3 py-1 bg-slate-100 rounded-lg text-[9px] font-black text-slate-500 uppercase">
                                    {log.gateway_id}
                                </span>
                            </td>

                            { /* Status */}
                            <td className="px-10 py-8 font-black text-[10px]">
                                {log.status === 'success' ? (
                                    <span className="text-green-500">SUCCESS</span>
                                ) : (
                                    <span className="text-red-500">FAILED</span>
                                )}
                            </td>

                            { /* Amount */}
                            <td className="px-10 py-8 font-extrabold text-slate-900">
                                {formatCurrency(log.order_total)}
                            </td>

                            { /* Error type or healthy */}
                            <td className="px-10 py-8">
                                <span className="text-[10px] font-bold text-slate-300 uppercase tracking-widest">
                                    {log.error_type || 'Healthy'}
                                </span>
                            </td>

                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default TransactionTable;