import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Auctions',
        href: "{route('admin.auction.index')}",
    },
];

export default function Auction({auctions}) {
    return (
        <div>
          <Head title="Auctions" />
          <div className='container mx-auto p-4'> 
            <div className='flex justify-between items-center mb-4'>
              <a href={route('admin.dashboard')} className='text-gray-500 ml-2'>Back</a>
            </div>
            <div className='flex justify-between items-center mb-4'>
              <h1 className='text-2xl font-bold'>Auctions</h1>
              <Link href={route('admin.auction.create')} className='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600'>Create Auction</Link>
            </div>
            <div className='overflow-x-auto'>
              <table className='w-full table-auto shadow bg-white rounded-lg border border-gray-200 divide-y divide-gray-200 divide-solid'>
                <thead>
                  <tr>
                    <th className='px-4 py-2 text-left'>ID</th>
                    <th className='px-4 py-2 text-left'>Title</th>
                    <th className='px-4 py-2 text-left'>Start Date</th>
                    <th className='px-4 py-2 text-left'>End Date</th>
                    <th className='px-4 py-2 text-left'>Status</th>
                    <th className='px-4 py-2 text-left'>Created At</th>
                    <th className='px-4 py-2 text-left'>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {
                    auctions.map((auction, index) => (
                      <tr key={index}>
                        <td className='px-4 py-2'>{auction.id}</td>
                        <td className='px-4 py-2'>{auction.title}</td>
                        <td className='px-4 py-2'>2021-09-01</td>
                        <td className='px-4 py-2'>2021-09-30</td>
                        <td className='px-4 py-2'>Active</td>
                        <td className='px-4 py-2'>{auction.created_at}</td>
                        <td className='px-4 py-2'>
                          <Link href={route('admin.auction.edit', auction.id)} className='text-blue-500'>Edit</Link>
                          <Link href={route('admin.auction.destroy', auction.id)} method='delete' as='button'
                          onClick={(e) => confirm('Are you sure you want to delete this auction?') ? e : e.preventDefault()}
                          className='cursor-pointer text-red-500 ml-2'>Delete</Link>
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
