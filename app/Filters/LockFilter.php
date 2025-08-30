<?php

namespace App\Filters;

use App\Libraries\ResponseJSONCollection;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LockFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $db = \Config\Database::connect();
        // get id unit
        $uri = $request->getUri();
        $id = $uri->getSegment(2);
        $type = $arguments[0] ?? null;
        if ($type === 'material') {
            $data = $db->table('closing c')->select('c.status')
                ->join('closing_detail cd', 'cd.closing_id = c.id_closing')
                ->join('unit_material um', 'um.unit_id = cd.unit_id')
                ->where(['um.id_unit_material' => $id, 'c.status' => 1])
                ->countAllResults();
        } else {
            $data = $db->table('closing c')->select('cd.unit_id')
                ->join('closing_detail cd', 'cd.closing_id = c.id_closing')->where(['cd.unit_id' => $id, 'c.status' => 1])
                ->countAllResults();
        }

        if ($data > 0) {
            return ResponseJSONCollection::error(
                [],
                'Data unit sudah di lock.',
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
