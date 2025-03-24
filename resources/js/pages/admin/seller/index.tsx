import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sellers',
        href: "{route('admin.seller.index')}",
    },
];

export default function Auction({sellers}) {
    return (
        <div>
          <Head title="Sellers" />
          <div className='container mx-auto p-4'> 
            <div className='flex justify-between items-center mb-4'>
              <a href={route('admin.dashboard')} className='text-gray-500 ml-2'>Back</a>
            </div>
            <div className='flex justify-between items-center mb-4'>
              <h1 className='text-2xl font-bold'>Sellers</h1>
              <Link href={route('admin.seller.create')} className='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600'>Create Seller</Link>
            </div>
            <div className='overflow-x-auto'>
              <table className='w-full table-auto shadow bg-white rounded-lg border border-gray-200 divide-y divide-gray-200 divide-solid'>
                <thead>
                  <tr>
                    <th className='px-4 py-2 text-left'>ID</th>
                    <th className='px-4 py-2 text-left'>Name</th>
                    <th className='px-4 py-2 text-left'>Email</th>
                    <th className='px-4 py-2 text-left'>Phone</th>
                    <th className='px-4 py-2 text-left'>Status</th>
                    <th className='px-4 py-2 text-left'>Created At</th>
                    <th className='px-4 py-2 text-left'>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {
                    sellers.map((seller, index) => (
                      <tr key={index}>
                        <td className='px-4 py-2'>{seller.id}</td>
                        <td className='px-4 py-2'>{seller.name}</td>
                        <td className='px-4 py-2'>{seller.email}</td>
                        <td className='px-4 py-2'>{seller.phone}</td>
                        <td className='px-4 py-2'>Active</td>
                        <td className='px-4 py-2'>{seller.created_at}</td>
                        <td className='px-4 py-2'>
                          <Link href={route('admin.seller.edit', seller.id)} className='text-blue-500'>Edit</Link>
                          <Link href={route('admin.seller.destroy', seller.id)} method='delete' as='button'
                          onClick={(e) => confirm('Are you sure you want to delete this seller?') ? e : e.preventDefault()}
                          className='cursor-pointer text-red-500 ml-2'>Delete</Link>
                          <Link href={route('admin.seller.edit', seller.id)} className='text-gray-500 ml-2'>Impersonate</Link>
                        </td>
                      </tr>
                    ))
                  }
                </tbody> 
              </table>
            </div>
          </div>
      </div>
    );
}
